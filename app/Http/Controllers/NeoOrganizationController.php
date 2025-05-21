<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NeoOrganization; 
use App\Models\NeoTenant; 
use RealRashid\SweetAlert\Facades\Alert;

class NeoOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $neoOrganizations = NeoOrganization::all();
        return view('neoorganizations.index', compact('neoOrganizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $neoTenants = NeoTenant::all();
        $neoOrganizations = NeoOrganization::all();       
        return view('neoorganizations.create', compact('neoTenants','neoOrganizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //        
        $request->validate([           
            'parent_id'=> 'nullable',
            'neo_tenant_id' => 'required|exists:neo_tenants,id',
            'lms_organization' => 'required|integer|min:1',
            'name_organization' => 'required|string|max:255',   
            'type_operation' => 'required|in:Operacion,SEP,Master,Proveedor, N/A', // :operacion,SEP,master, proveedor, N/A                      
        ]);             
        $NeoOrganization = NeoOrganization::create([
            'parent_id' => $request->parent_id == 'Select' ? 0 : $request->parent_id,
            'neo_tenant_id' => $request->neo_tenant_id,
            'lms_organization' => $request->lms_organization,
            'name_organization' => $request->name_organization,
            'type'=> $request->type_operation
            ]);
        Alert::toast('Create Neo Organization successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        
        return redirect()->route('neoorganizations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $neoOrganization = NeoOrganization::findOrFail($id);
        return view('neoorganizations.show', compact('neoOrganization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $neoOrganization = NeoOrganization::findOrFail($id);
         $neoOrganizations = NeoOrganization::all();  
        $neoTenants = NeoTenant::all();
       /*  $statuses = Status::all();         */  
        // Return the view to edit the user
        return view('neoorganizations.edit', compact('neoOrganization','neoTenants','neoOrganizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'parent_id'=> 'nullable',
            'neo_tenant_id' => 'required|exists:neo_tenants,id',
            'lms_organization' => 'required|integer|min:1',
            'name_organization' => 'required|string|max:255',  
            'type_operation' => 'required|in:Operacion,SEP,Master,Proveedor, N/A', // :operacion,SEP,master, proveedor, N/A                      
        ]);    
        $neoOrganization = NeoOrganization::findOrFail($id);         
        $neoOrganization = $neoOrganization->update([
            $request->parent_id == 'Select' ? 0 : $request->parent_id,
            'neo_tenant_id' => $request->neo_tenant_id,
            'lms_organization' => $request->lms_organization,
            'name_organization' => $request->name_organization,
            'type'=> $request->type_operation
            ]);
        Alert::toast('Update Neo Organization successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        
        return redirect()->route('neoorganizations.index');        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
