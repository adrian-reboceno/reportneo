<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NeoTenant; 
use App\Models\Status;
use RealRashid\SweetAlert\Facades\Alert;

class NeoTenantController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:neotenant-list|user-create|neotenant-edit|neotenant-delete', ['only' => ['index','store']]);
        $this->middleware('permission:neotenant-create', ['only' => ['create','store']]);
        $this->middleware('permission:neotenant-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:neotenant-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $neoTenants = NeoTenant::all();
        return view('neotenants.index', compact('neoTenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $statuses = Status::all();
        return view('neotenants.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //       
        $request->validate([
            'idportal' => 'required|integer|min:1',
            'school_name' => 'required|string|max:255',
            'url' => 'required|string|url|max:255',
            'privatekey' => 'required|string|max:255',  
            'status_id' => 'required|exists:statuses,id',                           
        ]);
        $NeoTenant = NeoTenant::create([
            'idportal' => $request->idportal,
            'school_name' => $request->school_name,
            'url' => $request->url,
            'privatekey' => $request->privatekey,
            'status_id' => $request->status_id,
            ]);
        Alert::toast('Create neo tenant successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        
        return redirect()->route('neotenants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $neotenant = NeoTenant::findOrFail($id);
        return view('neotenants.show', compact('neotenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $neotenant = NeoTenant::findOrFail($id);
        // Fetch all statuses from the database
        $statuses = Status::all();               
        // Return the view to edit the user
        return view('neotenants.edit', compact('neotenant', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'idportal' => 'required|integer|min:1',
            'school_name' => 'required|string|max:255',
            'url' => 'required|string|url|max:255',
            'privatekey' => 'required|string|max:255',  
            'status_id' => 'required|exists:statuses,id',                           
        ]);
        $NeoTenant = NeoTenant::findOrFail($id);
        $NeoTenant->update([
            'idportal' => $request->idportal,
            'school_name' => $request->school_name,
            'url' => $request->url,
            'privatekey' => $request->privatekey,
            'status_id' => $request->status_id,
            ]);
        Alert::toast('Update neo tenant successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        
        return redirect()->route('neotenants.index');  
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
