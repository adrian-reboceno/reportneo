<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NeoTenant; 
use App\Models\NeoClass; 
use App\Models\NeoPerson; //NeoPerson 
use App\Models\NeoClassAttendanceSessionUser;
use App\Jobs\ExportAttendanceSessionUsersJob;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;



class AttendanceExportController extends Controller
{
    //    
    public function showForm()
    {
        // Return a view with a form to export attendance
        $neoTenants = NeoTenant::all();       
        return view('report.attendance.export', compact('neoTenants'));
    }
    public function export(Request $request)
    {
        
        $request->validate([
            'neo_tenant_id' => 'required|exists:neo_tenants,id',
            'organization_id' => 'required|exists:neo_organizations,id',
        ]);

       
/* 
         $classes = NeoClass::query()
        ->where('neo_organization_id',$request->organization_id)    // Filtrar por organización específica
        ->whereHas('attendanceSessions')               // Solo clases con sesiones
        ->with([
            'teachers',                                // Cargar profesores
            'students',                                // Cargar estudiantes
            'attendanceSessions',                      // Opcional: cargar sesiones
            'organization'                             // Cargar la organización asociada
        ])->get();     
 */
       /*  var_dump($classes); */
       
       /*  foreach ($classes as $class) {
            # code...
           
           foreach ($class->students as $student) {
                    # code...
                    $person = NeoPerson::find($student->neo_person_id);
                    foreach ($class->attendanceSessions as $attendanceSession) {
                        # code...
                        $attendanceSessionUser = NeoClassAttendanceSessionUser::firstOrNew([
                            'session_id' => $attendanceSession->id,
                            'neo_person_id' => $student->neo_person_id,
                        ]);
                        var_dump($attendanceSessionUser);
                    }
                }
        } */
        ExportAttendanceSessionUsersJob::dispatch($request->neo_tenant_id, $request->organization_id,  Auth::user()->id);

        Alert::toast('Reporte Attendance Session iniciado. Te notificaremos al finalizar.!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('dashboard');              
    }
    
}
