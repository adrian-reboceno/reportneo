<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NeoOrganization; 
use App\Models\NeoTenant; 
use App\Models\NeoApi;
use RealRashid\SweetAlert\Facades\Alert;
use App\Jobs\SyncClassesByOrganizationJob;
use Illuminate\Support\Facades\Auth;

class SyncNeoClassController extends Controller
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
        return view('syncneo.classes.create', compact('neoTenants'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'neo_tenant_id' => 'required|exists:neo_tenants,id',
            'organization_id' => 'required|exists:neo_organizations,id',
        ]);
        $tenant = NeoTenant::findOrFail($request->neo_tenant_id);
        $NeoOrganization = NeoOrganization::findOrFail($request->organization_id);  
        SyncClassesByOrganizationJob::dispatch($request->neo_tenant_id, $NeoOrganization->lms_organization, Auth::user()->id);
        Alert::toast('Sincronización de class iniciada. Te notificaremos al finalizar.!', 'success')
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
