<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NeoOrganization; 
use App\Models\NeoTenant; 
use App\Jobs\SyncClassesByStudentJob;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class SyncNeoClassStudentController extends Controller
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
        $neoTenants = NeoTenant::all();             
        return view('syncneo.classstudents.create', compact('neoTenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         // dd($request->all());
        $request->validate([
            'neo_tenant_id' => 'required|exists:neo_tenants,id',
            'organization_id' => 'required|exists:neo_organizations,id',
        ]);

        SyncClassesByStudentJob::dispatch($request->neo_tenant_id, $request->organization_id,  Auth::user()->id);
        Alert::toast('Sincronización de students by class iniciada. Te notificaremos al finalizar.!', 'success')
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
