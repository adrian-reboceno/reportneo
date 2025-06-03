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
use App\Models\NeoPerson;
use App\Models\NeoApi;
use App\Models\NeoClass;
use App\Models\User;
use App\Models\NeoClassStudent;
use App\Notifications\SyncCompletedNotification;


class SyncClassesByStudentJob implements ShouldQueue
{
    use Queueable;
    public $tenantId;
    public $OrganizationId;
    public $userId;
    /**
     * Create a new job instance.
     */
    public function __construct(int $tenantId, int $OrganizationId, int $userId = null)
    {
        //
        $this->tenantId = $tenantId;
        $this->OrganizationId = $OrganizationId;
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
        $organization  = NeoOrganization::find($this->OrganizationId);

        if (!$organization) {
            Log::warning("SyncUsersByOrganizationJob: Organización {$organization->lms_organization} no encontrada para tenant {$tenant->id}");
            return;
        }
        $neoClasses = NeoClass::where('neo_tenant_id',  $this->tenantId )
        ->where('neo_organization_id', $this->OrganizationId)
        ->where('neo_status_id', 1)
        ->get();
        if ($neoClasses->isEmpty()) {
            Log::info("No hay classes para sincronizar en {$organization->name_organization} ({$organization->lms_organization})");
            return;
        }
        $callCount = 0;
        Log::info("⏳ Iniciando sync para org {$organization->name_organization} ({$organization->lms_organization})");
        try {    
            foreach ($neoClasses as $neoClass) {
                
                $syncedInClass = 0;
                $offset = 0;
                $limit = 100; // o el que permita tu API
                $hasMore = true;
                while ($hasMore) {
                    // ...
                    $batch = $api->get_class_students($neoClass->lms_class, [
                        '$limit' => $limit,
                        '$offset' => $offset,
                    ]);
                    if (!empty($batch)) {
                        foreach ($batch as $student) {
                            $neoPerson = NeoPerson::where('lms_id', $student->user_id)
                                ->where('neo_tenant_id', $this->tenantId)
                                ->first();
                            if (!$neoPerson) {
                                Log::warning("No se encontró NeoPerson para user_id {$student->user_id} en tenant {$this->tenantId}");
                                continue;
                            }
                            NeoClassStudent::updateOrCreate(
                                [
                                    'neo_class_id' => $neoClass->id,
                                    'neo_person_id' => $neoPerson->id,
                                ],
                                [
                                    'neo_class_id' => $neoClass->id,
                                    'neo_person_id' => $neoPerson->id,
                                    'enrolled_at' => $student->enrolled_at,
                                    'enroll_type' => $student->enroll_type,
                                    'enrolled_by_id' => $student->enrolled_by_id ?? 0,
                                    'started' => $student->started,
                                    'started_at' => $student->started_at,
                                    'completed' => $student->completed,
                                    'unenrolled' => $student->unenrolled,
                                    'deactivated' => $student->deactivated,
                                    'transferred' => $student->transferred,
                                    'class_archived' => $student->class_archived,
                                    'user_archived' => $student->user_archived,
                                    'percent' => $student->percent ?? 0.0,
                                    'grade' => $student->grade ?? 0.0,
                                    'override_percent' => $student->override_percent ?? null,
                                    'override_comment' => $student->override_comment ?? null,
                                    'override_by_id' => $student->override_by_id ?? null,
                                    'override_at' => $student->override_at  ?? null,
                                    'time_spent' => $student->time_spent,
                                    'last_visited_at' => $student->last_visited_at,
                                    'order_item_id' => $student->order_item_id ?? null,                                
                                ]
                            );
                            Log::info("🎯 Sincronizando student {$student->user_id} para class {$neoClass->name}  { $student->class_id} en {$organization->name_organization}");                           
                            $syncedInClass++;
                            $totalSynced++;
                        }
                        // ...
                         // Si recibiste menos de $limit, ya no hay más
                        $hasMore = count($batch) === $limit;
                        $offset += $limit;
                    
                    } else {
                        $hasMore = false; // No hay más datos
                    }
                    $callCount++;
                    if ($callCount % 120 === 0) {
                        Log::info("Esperando 60 segundos por límite de API...");
                        sleep(60);
                    }     
                }

                Log::info("✅ Sincronizados $syncedInClass students de class {$neoClass->name} en {$organization->name_organization}");
                $callCount++;
                if ($callCount % 120 === 0) {
                    Log::info("Esperando 60 segundos por límite de API...");
                    sleep(60);
                }                            
            }
            $totalSynced = count($neoClasses);
            Log::info("Sycn {$totalSynced} class de {$organization->name_organization} ({$organization->lms_organization})");

        } catch (\Exception $e) {
            Log::error("Error al sincronizar las classes:" . $e->getMessage());
        }
        if ($totalSynced == 0) {
            Log::info("No se encontraron classes para sincronizar en {$organization->name_organization} ({$organization->lms_organization})");
        } else {
            Log::info("Sincronización de student for class finalizada para {$organization->name_organization} ({$organization->lms_organization}). Total sincronizados: {$totalSynced}");
        }
        $user = User::find($this->userId);
        if ($user) {
            $user->notify(new SyncCompletedNotification(
                $tenant->school_name,
                $organization->name_organization,
                $totalSynced,
                'student in class'
            ));
        }
    }
}
