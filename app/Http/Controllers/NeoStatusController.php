<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\NeoStatus;

class NeoStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $neostatuses = NeoStatus::all();
        return view('neostatuses.index', compact('neostatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
        return view('neostatuses.create');
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
        NeoStatus::create([
            'status_name' => $request->status_name,
            'description' => $request->description,
            'status_color' => $request->status_color,
        ]);
        Alert::toast('Create status create successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('neostatuses.index');   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $neostatus = NeoStatus::findOrFail($id);
        return view('neostatuses.show', compact('neostatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $neostatus = NeoStatus::findOrFail($id);
        return view('neostatuses.edit', compact('neostatus'));
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
        $NeoStatus = NeoStatus::findOrFail($id);
        $NeoStatus->update([
            'status_name' => $request->status_name,
            'description' => $request->description,
            'status_color' => $request->status_color,
        ]);
        Alert::toast('Status updated successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('neostatuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
