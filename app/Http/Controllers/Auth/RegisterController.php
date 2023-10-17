<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\RegistrationConfirmation;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = 'user';

    public function __construct()
    {
        // Remove the middleware to prevent automatic login after registration
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/(.+)@(.+)\.(.+)/i'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required', 'string', 'size:10'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['mobile'],
            'is_active' => $data['is_active'],
            'admin' => 0,
        ]);
        if ($data['profile_picture']) {
            $imagePath = $data['profile_picture']->store('profile_pictures', 'public'); // Store the image in the "public" disk under the "profile_pictures" directory
            $user->profile_picture = $imagePath; // Save the path to the database
            $user->save();
        }

        // Check if the selected role is "superadmin"
        $role = Role::find($data['role']);
        if ($role && $role->name === 'superadmin') {
            $user->admin = 1; 
            $user->save();
        }

        $user->assignRole($data['role']);
        $user->notify(new RegistrationConfirmation());
        return $user;
    }

    // Override the default register method to prevent auto-login
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        return redirect($this->redirectPath())->with('success', 'User registered successfully. Please log in.');
    }

    public function showRegistrationForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }
}
