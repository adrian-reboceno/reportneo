<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NeoApi; 
use App\Models\NeoTenant; 
use App\Models\Status;
use RealRashid\SweetAlert\Facades\Alert;

class NeoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $neoApis = NeoApi::all();
        return view('neoapis.index', compact('neoApis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $neoTenants = NeoTenant::all();
        $statuses = Status::all();
        return view('neoapis.create', compact('neoTenants','statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //       
        $request->validate([
            'neo_tenant_id' => 'required|exists:neo_tenants,id',
            'hostapi' => 'required|string|max:255',
            'apikey' => 'required|string|max:255',
            'version' => 'required|string|max:255',  
            'status_id' => 'required|exists:statuses,id',                           
        ]);         
        $NeoApi = NeoApi::create([
            'neo_tenant_id' => $request->neo_tenant_id,
            'hostapi' => $request->hostapi,
            'apikey' => $request->apikey,
            'version' => $request->version,
            'status_id' => $request->status_id,
            ]);
        Alert::toast('Create neo api successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        
        return redirect()->route('neoapis.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $neoApi = NeoApi::findOrFail($id);
        return view('neoapis.show', compact('neoApi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $neoApi = NeoApi::findOrFail($id);
        $neoTenants = NeoTenant::all();
        $statuses = Status::all();          
        // Return the view to edit the user
        return view('neoapis.edit', compact('neoApi','neoTenants', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'neo_tenant_id' => 'required|exists:neo_tenants,id',
            'hostapi' => 'required|string|max:255',
            'apikey' => 'required|string|max:255',
            'version' => 'required|string|max:255',  
            'status_id' => 'required|exists:statuses,id',                           
        ]);                
        $neoApi = NeoApi::findOrFail($id);
        $NeoApi = $neoApi->update([
            'neo_tenant_id' => $request->neo_tenant_id,
            'hostapi' => $request->hostapi,
            'apikey' => $request->apikey,
            'version' => $request->version,
            'status_id' => $request->status_id,
            ]);
        Alert::toast('Update neo api successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        
        return redirect()->route('neoapis.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
