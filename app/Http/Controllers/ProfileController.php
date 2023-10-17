<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    
    public function update(Request $request)
    {
       
        $user = Auth::user( );
      
        $user->user_name = $request->input('user_name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');

        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePicturePath = $profilePicture->store('profile_pictures', 'public');
            $user->profile_picture = $profilePicturePath;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
    public function changePassword(Request $request)
{
    $request->validate([
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    $user->password = Hash::make($request->input('new_password'));

    $user->save();

    return redirect()->route('profile')->with('success', 'Password changed successfully!');
}

}
