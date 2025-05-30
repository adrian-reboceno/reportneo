<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\NeoClass;
use App\Jobs\SyncAttendanceSessionJob;

class SyncNeoClassAttendanceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $NeoClasses = NeoClass::with([
            'attendanceSessions',
            'organization',
            'teachers.neoPerson' // incluye los datos del docente
        ])->whereHas('attendanceSessions')
        ->get();
        return view('syncneo.attendancesessions.create', compact('NeoClasses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {      
        $request->validate([          
            'ids' => 'required',
        ]);

       /*  dd($request->all()); */
        // Split the comma-separated string into an array
        
        $ids = array_map('trim', explode(',', $request->ids));
        SyncAttendanceSessionJob::dispatch(1,  $ids ,  Auth::user()->id);
        Alert::toast('Sincronización de sessions users by class iniciada. Te notificaremos al finalizar.!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
