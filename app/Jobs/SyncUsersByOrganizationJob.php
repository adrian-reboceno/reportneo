<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\NeoTenant;
use App\Helpers\NeoApi\NeoApiV3;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\NeoOrganization;
use App\Models\NeoProfile;
use App\Models\NeoApi;
use App\Models\NeoPerson;
use App\Models\NeoPersonProfile;
use App\Models\NeoPersonOrganization;
use App\Models\User;
use App\Notifications\SyncCompletedNotification;

class SyncUsersByOrganizationJob implements ShouldQueue
{
    use Queueable;
    public $tenantId;
    public $lmsOrganization;
    public $profileId;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $tenantId, int $lmsOrganization, int $profileId, int $userId = null)
    {
        $this->tenantId = $tenantId;
        $this->lmsOrganization = $lmsOrganization;
        $this->userId = $userId;
        $this->profileId = $profileId;
    }   

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $tenant = NeoTenant::find($this->tenantId);

        if (!$tenant) {
            Log::warning("SyncUsersByOrganizationJob: Tenant {$this->tenantId} no encontrado.");
            return;
        }
        $api = new NeoApiV3([
            'host' => $tenant->api->hostapi ,
            'api_key' => $tenant->api->apikey,
            'api_version' => $tenant->api->version ?? 'v3',
            'use_ssl' =>  true,
            'debug' => true,
        ]);
        $limit = 100;
        $offset = 0;
        $totalSynced = 0;       
        $organization  = NeoOrganization::where('lms_organization',$this->lmsOrganization)->first();

        if (!$organization) {
            Log::warning("SyncUsersByOrganizationJob: Organización {$this->lmsOrganization} no encontrada para tenant {$tenant->id}");
            return;
        }

        $profile = NeoProfile::find($this->profileId);
        if (!$profile) {
            Log::warning("SyncUsersByOrganizationJob: Perfil {$this->profileId} no encontrado para tenant {$tenant->id}");
            return;
        }
        $role= $profile->profile_name;       
        $filter = '{"roles":"'.$role.'"}';
        $callCount = 0;
        Log::info("⏳ Iniciando sync para org {$organization->name_organization} ({$organization->lms_organization})");
        try {
            while (true) {
                $batch = $api->get_users_by_organization($organization->lms_organization, [
                    '$limit' => $limit,
                    '$filter' => $filter,
                    '$offset' => $offset,
                ]);

                if (empty($batch)) {
                    break;
                }

                foreach ($batch as $user) {
                    $person = NeoPerson::updateOrCreate(
                        ['neo_tenant_id' => $tenant->id, 'lms_id' => $user->id],
                        [
                            'neo_tenant_id' => $tenant->id,
                            'neo_status_id' => 1,
                            'lms_id' => $user->id,
                            'first_name' => $user->first_name,
                            'last_name' => $user->last_name,
                            'email' => $user->email,
                            'educational_program' => data_get($user, 'custom_fields.ProgramaEducativo'),
                            'studentID' => $user->studentID,
                            'teacherID' => $user->teacherID,
                            'joined_at' => $user->joined_at,
                            'first_login_at' => $user->first_login_at,
                            'last_login_at' => $user->last_login_at,
                            'last_login_ip' => $user->last_login_ip,
                            'sisid' => $user->sis_id,                            
                        ]
                    );

                    if (!$person) {
                        Log::error("Error al crear o actualizar persona para usuario {$user->first_name} {$user->last_name} ({$user->email})");
                        continue;
                    }

                    $NeoPersonProfile = NeoPersonProfile::updateOrCreate(
                        ['neo_person_id' => $person->id, 'neo_profile_id' => $profile->id],
                        [
                            'neo_profile_id' => $profile->id,
                            'neo_person_id' => $person->id,
                        ]
                    );
                    $NeoPersonOrganization = NeoPersonOrganization::updateOrCreate(
                        ['neo_person_id' => $person->id, 'neo_organization_id' => $organization->id],
                        [
                            'neo_person_id' => $person->id,
                            'neo_organization_id' => $organization->id,
                        ]
                    );

                    Log::info("Insertando usuario {$user->first_name} {$user->last_name} ({$user->email}) en {$organization->name_organization} ({$organization->lms_organization}) role {$profile->id}");
                }
                $callCount++;
                if ($callCount % 120 === 0) {
                    Log::info("Esperando 60 segundos por límite de API...");
                    sleep(60);
                }
                $totalSynced += count($batch);
                Log::info("Sincronizados {$totalSynced} usuarios de {$organization->name_organization} ({$organization->lms_organization})");
                $offset += count($batch);
            }
        } catch (\Exception $e) {
            Log::error("Error al sincronizar usuarios:" . $e->getMessage());
        }
        if ($totalSynced == 0) {
            Log::info("No se encontraron usuarios para sincronizar en {$organization->name_organization} ({$organization->lms_organization})");
        } else {
            Log::info("Sincronización de usuarios finalizada para {$organization->name_organization} ({$organization->lms_organization}). Total sincronizados: {$totalSynced}");
        }
        $user = User::find($this->userId);
        if ($user) {
            $user->notify(new SyncCompletedNotification(
                $tenant->school_name,
                $organization->name_organization,
                $totalSynced,
                $role
            ));
        }
        
    }
}
