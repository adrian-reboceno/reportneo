<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Helpers\NeoApi\NeoApiV3;
use App\Models\NeoTenant;
use App\Models\NeoOrganization;
use App\Models\NeoApi;
use App\Models\NeoClass;

use App\Models\User;
use App\Notifications\SyncCompletedNotification;

class SyncClassesByOrganizationJob implements ShouldQueue
{
    use Queueable;

    public $tenantId;
    public $lmsOrganization;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $tenantId, int $lmsOrganization, int $userId = null)
    {
        //
        $this->tenantId = $tenantId;
        $this->lmsOrganization = $lmsOrganization;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $tenant = NeoTenant::find($this->tenantId);

        if (!$tenant) {
            Log::warning("SyncClassesByOrganizationJob: Tenant {$this->tenantId} no encontrado.");
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
        $callCount = 0;
        Log::info("⏳ Iniciando sync para org {$organization->name_organization} ({$organization->lms_organization})");
        try {
            //code...
            while (true) {
                $batch = $api->get_classes_by_organization($organization->lms_organization, [
                    '$limit' => $limit,
                    '$offset' => $offset,
                ]);

                if (empty($batch)) {
                    break;
                }
                foreach ($batch as $class) {
                    $classData = [
                        'neo_tenant_id' => $tenant->id,
                        'neo_organization_id' => $organization->id,
                        'neo_status_id' => 1,
                        'lms_class' => $class->id,
                        'parent_id' => $class->parent_id,
                        'name' => $class->name,
                        'access_code' => $class->access_code,
                        'creator_id' => $class->metadata->creator_id,
                        'createdat' => $class->metadata->created_at,
                        'language' => $class->metadata->language,
                        'subject' => $class->metadata->subject,
                        'used_seats' => $class->used_seats,
                        'style' => $class->style,
                        'start_at' => $class->start_at,
                        'finish_at' => $class->finish_at,
                        'time_zone' => $class->time_zone,
                        'section_code' => $class->section_code
                    ];

                    NeoClass::updateOrCreate(
                        ['neo_tenant_id' => $tenant->id, 'neo_organization_id' => $organization->id, 'lms_class' => $class->id],
                        $classData
                    );                   
                    Log::info("Clase sincronizada {$class->name} section_code: {$class->section_code}  en {$organization->name_organization} ({$organization->lms_organization})");                   
                }
                $callCount++;
                if ($callCount % 120 === 0) {
                    Log::info("Esperando 60 segundos por límite de API...");
                    sleep(60);
                }
                $totalSynced += count($batch);
                Log::info("Sycn {$totalSynced} class de {$organization->name_organization} ({$organization->lms_organization})");
                $offset += count($batch);
                
            }
        } catch (\Exception $e) {
            Log::error("Error al sincronizar las classes:" . $e->getMessage());
        }
        if ($totalSynced == 0) {
            Log::info("No se encontraron classes para sincronizar en {$organization->name_organization} ({$organization->lms_organization})");
        } else {
            Log::info("Sincronización de classes finalizada para {$organization->name_organization} ({$organization->lms_organization}). Total sincronizados: {$totalSynced}");
        }
        $user = User::find($this->userId);
        if ($user) {
            $user->notify(new SyncCompletedNotification(
                $tenant->school_name,
                $organization->name_organization,
                $totalSynced,
                'class'
            ));
        }
    }
}
