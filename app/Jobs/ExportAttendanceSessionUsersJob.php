<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use App\Notifications\SyncCompletedNotification;
use App\Models\NeoClass;
use App\Models\User;
use App\Models\NeoTenant;
use App\Models\NeoOrganization;
use App\Models\NeoClassAttendanceSessionUser;
use App\Models\NeoPerson;
use App\Models\NeoClassAttendanceSession;

class ExportAttendanceSessionUsersJob implements ShouldQueue
{
    use Queueable;
    public $tenantId;
    public $OrganizationId;
    public $userId;
    public $export = []; // Variable para exportar datos
    /**
     * Create a new job instance.
     */
    public function __construct(int $tenantId, int $OrganizationId, int $userId = null)
    {
        //
        $this->tenantId = $tenantId;
        $this->OrganizationId = $OrganizationId;
        $this->userId = $userId;
        $this->export = []; // Inicializar la variable de exportación
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        ini_set('memory_limit', '512M');
        $tenant = NeoTenant::find($this->tenantId);
        if (!$tenant) {
            Log::warning("ExportAttendanceSessionUsersJob: Tenant {$this->tenantId} no encontrado.");
            return;
        }
        $organization = NeoOrganization::find($this->OrganizationId);
        if (!$organization) {
            Log::warning("ExportAttendanceSessionUsersJob: Organization {$this->OrganizationId} no encontrada.");
            return;
        }
        $classes = NeoClass::query()
        ->where('neo_organization_id', $this->OrganizationId)    // Filtrar por organización específica
        ->whereHas('attendanceSessions')               // Solo clases con sesiones
        ->with([
            'teachers',                                // Cargar profesores
            'students',                                // Cargar estudiantes
            'attendanceSessions',                      // Opcional: cargar sesiones
            'organization'                             // Cargar la organización asociada
        ])->get();     
        if ($classes->isEmpty()) {
            Log::info("ExportAttendanceSessionUsersJob: No se encontraron clases para la organización {$this->OrganizationId}.");
            return;
        }
        try {
            foreach ($classes as $class) {
                // Obtener las sesiones de asistencia de la clase
                $parts = explode('-', $class->section_code);              
                foreach ($class->students as $student) {
                    # code...                    
                    $attendance= []; // Inicializar el array de asistencia para cada estudiante
                    foreach ($class->attendanceSessions as $attendanceSession) {
                        # code...                         
                        $attendanceSessionUser = NeoClassAttendanceSessionUser::firstOrNew([
                            'session_id' => $attendanceSession->id,
                            'neo_person_id' => $student->neo_person_id,
                        ]);                       
                        $attendance[] = [
                            'started_at' => $attendanceSession->started_at,
                            'finished_at' => $attendanceSession->finished_at,
                            'status' => $attendanceSessionUser->status , // Valor por defecto si no hay estado   
                            'arrived_late' => $attendanceSessionUser->arrived_late , // Valor por defecto si no hay asistencia       
                            'left_early' => $attendanceSessionUser->left_early , // Valor por defecto si no hay asistencia   
                            'excused' => $attendanceSessionUser->excused , // Valor por defecto si no hay asistencia
                            'note' => $attendanceSessionUser->note , // Valor por defecto si no hay comentario
                        ];                                                                                           
                    }
                    $this->export[] = [
                        'lms_clas' => $class->lms_class,
                        'Periodo' => $parts[0] ?? '',
                        'CRN' => $parts[1] ?? '',
                        'Organizacion' => $class->organization->name_organization,
                        'name_class' => $class->name,
                        'student' => [
                            'lms_id' => $student->neoPerson->lms_id,
                            'first_name' => $student->neoPerson->first_name ?? '',
                            'last_name' => $student->neoPerson->last_name ?? '', 
                            'studentID' => $student->neoPerson->studentID ?? '', 
                            'email' => $student->neoPerson->email ?? '',
                            'assistance' => $attendance,                            
                        ]
                    ];
                }
            }
            $url = $this->ExcelExport($this->export);

            // Puedes guardar el resultado, por ejemplo:          
        } catch (\Throwable $e) {
            \Log::error('Error en ExportAttendanceSessionUsersJob: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'export_sample' => array_slice($this->export, 0, 1),
            ]);

            throw $e; // para que Laravel reintente si quieres
        }
        $user = User::find($this->userId);
        if ($user) {
            $user->notify(new SyncCompletedNotification(
                $tenant->school_name,
                'Organizartion: ' . $organization->name_organization,
                'classes: ' . count($classes),
                'Export Attendance Session Users'. $url,
                
            ));
        }
    }
    
    /**
     * Método para exportar los datos a un archivo Excel.
     */
    private function ExcelExport(array $export): string{

       /*  $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Establecer encabezados
        $headers = [
            'LMS Class', 'Periodo', 'CRN', 'Organizacion', 'Name Class',
            'LMS ID', 'First Name', 'Last Name', 'Student ID', 'Email'
        ];
        
        $sheet->fromArray($headers, null, 'A1');
        
        foreach ($export as $value) {
            # code...
        }
        $filename = 'export_' . now()->format('Ymd_His') . '.xlsx';
        $relativePath = 'exports/' . $filename;
        $fullPath = storage_path('app/public/' . $relativePath);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($fullPath);

        return Storage::url($relativePath); // Devuelve la URL pública */
        
        $rows = [];
        $maxSessions = 0;

        // Primera pasada: convertir estructura y detectar cantidad máxima de sesiones
        foreach ($export as $item) {
            $common = [
                'lms_class'      => $item['lms_clas'],
                'Periodo'        => $item['Periodo'],
                'CRN'            => $item['CRN'],
                'Organizacion'   => $item['Organizacion'],
                'name_class'     => $item['name_class'],
                'lms_id'         => $item['student']['lms_id'],
                'first_name'     => $item['student']['first_name'],
                'last_name'      => $item['student']['last_name'],
                'studentID'      => $item['student']['studentID'],
                'email'          => $item['student']['email'],
            ];

            $assistance = $item['student']['assistance'] ?? [];
            $maxSessions = max($maxSessions, count($assistance));

            // Guardamos todo junto
            $rows[] = [
                'common' => $common,
                'assistance' => $assistance,
            ];
        }

        // Crear encabezados
        $headers = array_keys($rows[0]['common']);
        for ($i = 0; $i < $maxSessions; $i++) {
            $headers[] = "Session " . ($i + 1) . " - Fecha inicio";
            $headers[] = "Session " . ($i + 1) . " - Fecha fin";
            $headers[] = "Session " . ($i + 1) . " - Estado";
            $headers[] = "Session " . ($i + 1) . " - Llegó tarde";
            $headers[] = "Session " . ($i + 1) . " - Salió temprano";
            $headers[] = "Session " . ($i + 1) . " - Justificado";
            $headers[] = "Session " . ($i + 1) . " - Nota";
        }

        // Crear el Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Escribir encabezados
        /* foreach ($headers as $colIndex => $header) {
            $sheet->setCellValueByColumnAndRow($colIndex + 1, 1, $header);
        } */
        foreach ($headers as $colIndex => $header) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            $cellAddress = $columnLetter . '1';
            $sheet->setCellValue($cellAddress, $header);
        }

        // Escribir filas
        foreach ($rows as $rowIndex => $row) {
            $data = array_values($row['common']);

            // Aplanar cada sesión
            for ($i = 0; $i < $maxSessions; $i++) {
                $session = $row['assistance'][$i] ?? [
                    'started_at' => '',
                    'finished_at' => '',
                    'status' => '',
                    'arrived_late' => '',
                    'left_early' => '',
                    'excused' => '',
                    'note' => '',
                ];

                $data[] = $session['started_at'];
                $data[] = $session['finished_at'];
                $data[] = $session['status'];
                $data[] = $session['arrived_late'];
                $data[] = $session['left_early'];
                $data[] = $session['excused'];
                $data[] = $session['note'];
            }

            foreach ($data as $colIndex => $value) {
               /*  $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 2, $value); */
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                $cellAddress = $columnLetter . ($rowIndex + 2);
                $sheet->setCellValue($cellAddress, $value);
            }
        }

        // Guardar archivo
        $filename = 'export_' . now()->format('Ymd_His') . '.xlsx';
        $relativePath = 'exports/' . $filename;
        $fullPath = storage_path('app/public/' . $relativePath);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($fullPath);

        return Storage::url($relativePath); // URL pública
    }
    
}
