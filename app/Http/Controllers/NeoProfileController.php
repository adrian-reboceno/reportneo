<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\NeoProfile;

class NeoProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $NeoProfiles = NeoProfile::all();
        // Return the roles to a view
        return view('neoprofiles.index', compact('NeoProfiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('neoprofiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'ProfileName' => 'required|unique:neo_profiles,profile_name',           
        ]);
        $NeoProfile = NeoProfile::create(['profile_name' => $request->ProfileName]);
        
        // Show success message
        Alert::toast('Create Neo Profile successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('neoprofiles.index');
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
        $NeoProfile = NeoProfile::findOrFail($id);
        // Fetch all permissions from the database
       
        return view('neoprofiles.edit', compact('NeoProfile' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'ProfileName' => 'required|unique:neo_profiles,profile_name',           
        ]);
        $NeoProfile = NeoProfile::findOrFail($id);
        $NeoProfile = $NeoProfile->update(['profile_name' => $request->ProfileName]);
        
        // Show success message
        Alert::toast('update Neo Profile successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('neoprofiles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
