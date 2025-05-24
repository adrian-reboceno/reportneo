<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NeoOrganization; 
use App\Models\NeoTenant; 
use App\Models\NeoApi;
use App\Helpers\NeoApi\NeoApiV3;
use RealRashid\SweetAlert\Facades\Alert;

class SyncNeoOrganizationController extends Controller
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
        return view('syncneo.organizations.create', compact('neoTenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        //
        $request->validate([
            'neo_tenant_id' => 'required|exists:neo_tenants,id',
        ]);
        $tenant = NeoTenant::findOrFail($request->neo_tenant_id);
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

        while (true) {
            $batch = $api->get_all_organization([
                '$limit' => $limit,
                '$offset' => $offset,
            ]);

            if (empty($batch)) {
                break;
            }

            foreach ($batch as $item) {               
                NeoOrganization::updateOrCreate(
                    ['lms_organization' => $item->id],
                    [
                        'parent_id' => $item->parent_id ?? 0,
                        'type' => $item->type ?? 'operacion',
                        'neo_tenant_id' => $request->neo_tenant_id,
                        'lms_organization' => $item->id ?? 0,
                        'name_organization' => ucfirst(strtolower($item->name)) ?? 'Sin nombre',
                    ]
                );
            }

            $totalSynced += count($batch);
            $offset += $limit;

            if (count($batch) < $limit) {
                break;
            }
        }

    Alert::success('Sincronización completa', "Se sincronizaron {$totalSynced} organizaciones.");
    return redirect()->route('neoorganizations.index');
    
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
