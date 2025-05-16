<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Status;

class StatusController extends Controller  
{
    /** 
     * middleware to check if the user is authenticated
     * and has the role of 'admin' or 'super-admin'
     */
    function __construct()
    {
        $this->middleware('permission:status-list|status-create|status-edit|status-delete', ['only' => ['index','store']]);
        $this->middleware('permission:status-create', ['only' => ['create','store']]);
        $this->middleware('permission:status-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:status-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $statuses = Status::all();
        return view('statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
        $request->validate([
            'status_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status_color' => 'nullable|string',
        ]);
        Status::create([
            'status_name' => $request->status_name,
            'description' => $request->description,
            'status_color' => $request->status_color,
        ]);
        Alert::toast('Create status create successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('status.index');   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $status = Status::findOrFail($id);
        return view('statuses.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $status = Status::findOrFail($id);
        return view('statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'status_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status_color' => 'nullable|string',
        ]);
        $status = Status::findOrFail($id);
        $status->update([
            'status_name' => $request->status_name,
            'description' => $request->description,
            'status_color' => $request->status_color,
        ]);
        Alert::toast('Status updated successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('status.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
