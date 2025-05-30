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
use App\Models\NeoClassAttendanceSession;
use App\Models\NeoClassAttendanceSessionUser;
use App\Models\NeoPerson;
use App\Notifications\SyncCompletedNotification;

class SyncAttendanceSessionJob implements ShouldQueue
{
    use Queueable;
    public $tenantId;
    public $classIds;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $tenantId, array $classIds, int $userId = null)
    {
        $this->tenantId = $tenantId;
        $this->classIds = $classIds;
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

        $neoClasses = NeoClass::where('neo_tenant_id',  $this->tenantId )
        ->whereIn('id',  $this->classIds)
        ->where('neo_status_id', 1)
        ->get();       
        if ($neoClasses->isEmpty()) {
            Log::warning("SyncAttendanceSessionJob: No se encontraron clases activas para el tenant {$tenant->id}");
            return;
        }
        $callCount = 0;
        try {           
            foreach ($neoClasses as $neoClass) {
                $sessions = NeoClassAttendanceSession::where('neo_class_id', $neoClass->id)->get();
                $syncedInClass = 0;               
                foreach ($sessions as $session) {
                    $offset = 0;
                    $limit = 100; // o el que permita tu API
                    $hasMore = true;
                    while ($hasMore) {

                        $batch = $api->get_user_attendance($neoClass->lms_class, $session->session_id, [
                            'limit' => $limit,
                            'offset' => $offset,
                        ]);
                        if (!empty($batch)) {
                            foreach ($batch as $sessionusers) {
                                # code...
                                $neoPerson = NeoPerson::where('lms_id', $sessionusers->user_id)->first();
                                if (!$neoPerson) {
                                    Log::warning("SyncAttendanceSessionJob: Persona no encontrada para user_id {$sessionusers->user_id} en clase {$neoClass->lms_class}");
                                    continue;
                                }
                                $attendanceSessionUser = NeoClassAttendanceSessionUser::updateOrCreate(
                                    [
                                        'session_id' => $session->id,
                                        'neo_person_id' => $neoPerson->id,
                                    ],
                                    [
                                        'session_id' => $session->id,
                                        'neo_person_id' => $neoPerson->id,
                                        'status' => $sessionusers->status,
                                        'arrived_late' => $sessionusers->arrived_late ?? false,
                                        'left_early' => $sessionusers->left_early ?? false,
                                        'excused' => $sessionusers->excused ?? false,
                                        'note' => $sessionusers->note ?? null,
                                    ]
                                );
                                log::info("SyncAttendanceSessionJob: Asistencia sincronizada para user_id {$sessionusers->user_id} en clase {$neoClass->lms_class} y sesión {$session->session_id}");                               
                            }
                            $totalSynced++;                            
                            // Si recibiste menos de $limit, ya no hay más
                            $hasMore = count($batch) === $limit;
                            $offset += $limit;                         
                        }else {
                            $hasMore = false; // No hay más datos
                        }
                        $callCount++;
                        if ($callCount % 120 === 0) {
                            Log::info("Esperando 60 segundos por límite de API...");
                            sleep(60);
                        }                          
                    }
                    $callCount++;
                    if ($callCount % 120 === 0) {
                        Log::info("Esperando 60 segundos por límite de API...");
                        sleep(60);
                    }  
                }
            }
            $totalSynced = count($neoClasses);
            Log::info("Sycn {$totalSynced} class ");
        } catch (\Exception $e) {
            Log::error("Error al sincronizar las classes:" . $e->getMessage());
        }
        if ($totalSynced == 0) {
            Log::info("No se encontraron classes para sincronizar en");
        } else {
            Log::info("Sincronización de attendance for class finalizada. Total sincronizados: {$totalSynced}");
        }
        $user = User::find($this->userId);
        if ($user) {
            $user->notify(new SyncCompletedNotification(
                $tenant->school_name,
                'All Organizartions',
                $totalSynced,
                'Attendance users in class'
            ));
        }
    }
}
