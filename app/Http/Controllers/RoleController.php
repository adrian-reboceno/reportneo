<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    /** 
     * middleware to check if the user is authenticated
     * and has the role of 'admin' or 'super-admin'
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Fetch all roles from the database
        $roles = Role::all();
        // Return the roles to a view
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Fetch all permissions from the database
        $permissions = Permission::all();
        // Return the permissions to a view
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'roleName' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);
        $role = Role::create(['name' => $request->roleName]);
        $role->syncPermissions($request->permissions);
        // Show success message
        Alert::toast('Create Role successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // Fetch the role by ID
        // Fetch the role by ID
        $role = Role::findOrFail($id);
        // Return the view to show the role
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // Fetch the role by ID
        $role = Role::findOrFail($id);
        // Fetch all permissions from the database
        $permissions = Permission::all();
        // Fetch the permissions assigned to the role
        //$rolePermissions = $role->permissions->pluck('id')->toArray();
        // Return the role and permissions to a view
        return view('roles.edit', compact('role', 'permissions', ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'roleName' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array'
        ]);
        // Find the role by ID
        $role = Role::findOrFail($id);
        // Update the role name
        $role->name = $request->roleName;
        // Save the role
        $role->save();
        // Sync the permissions with the role
        $role->syncPermissions($request->permissions);
        // Show success message
        Alert::toast('Update Role successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
