<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;
/* use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; */
use App\Models\User; // Assuming you have a User model
use App\Models\Status;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\FileHelper;
use Hash;

class UserController extends Controller 
{
    /** 
     * middleware to check if the user is authenticated
     * and has the role of 'admin' or 'super-admin'
     */
    
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // This method should return a list of users.
        // You can use Eloquent to fetch users from the database.
        // Example:
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Fetch all statuses from the database
        $statuses = Status::all();
        // fetch all roles from the database
        $roles = Role::all();
        return view('users.create', compact('statuses', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //        
        $request->validate([
            'name' => 'required|string|max:255',
            'paternal_surname' => 'required|string|max:255',
            'maternal_surname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required','min:8', 'confirmed', Rules\Password::defaults()],
            'avatar' => 'nullable|image|max:5120',   
            'status_id' => 'required|exists:statuses,id'        
        ]);
        if($request->hasFile('avatar')){            
            $uploadFile = $this->uploadFile($request);         
        }
        // Create a new user instance
        $user = User::create([
            'name' => $request->name,
            'paternal_surname' => $request->paternal_surname,
            'maternal_surname' => $request->maternal_surname,
            'phone_numbrer' => $request->phone_numbrer,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $uploadFile['file_path'],
            'status_id' => $request->status_id],
        );
        $user->syncRoles($request->roles);

        Alert::toast('Create user successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         // Fetch the user by ID
        $user = User::findOrFail($id);
        // Return the view to show the user
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // Fetch the user by ID
        $user = User::findOrFail($id);
        // Fetch all statuses from the database
        $statuses = Status::all();        
        // Fetch all roles from the database
        $roles = Role::all();
        // Return the view to edit the user
        return view('users.edit', compact('user', 'statuses','roles'));

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Validate the request data
       /*  dd($request->all()); */
        $request->validate([
            'name' => 'required|string|max:255',
            'paternal_surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,                  
            'maternal_surname' => 'nullable|string|max:255',            
            'status_id' => 'required|exists:statuses,id',
            'avatar' => 'nullable|image|max:5120' 
        ]);
        if($request->hasFile('avatar')){            
            $uploadFile = $this->uploadFile($request);         
        }
        // Fetch the user by ID
        $user = User::findOrFail($id);
        // Update the user data
        $user->name = $request->name;
        $user->paternal_surname = $request->paternal_surname;
        $user->maternal_surname = $request->maternal_surname;       
        $user->email = $request->email;       
        $user->status_id = $request->status_id;
        // Solo asigna el avatar si se subió uno
        if (isset($uploadFile)) {
            $user->avatar = $uploadFile['file_path'];
        }
        // Save the updated user data
        $user->save();
        $user->syncRoles($request->roles);
        Alert::toast('User updated successfully!', 'success')
        ->position('top-right')
        ->autoClose(3000)
        ->timerProgressBar();
        // Redirect to the index page
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function uploadFile(Request $request)
    {        
        $ruta = FileHelper::saveFile($request, 'avatars');       
        if (!$ruta) {
            return null;
        }
        return $ruta;
    }
}
