<?php

namespace App\Http\Controllers;
use Mail;
use Exception;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Notifications\RegistrationConfirmation;

class SocialController extends Controller
{
    // Redirect to Facebook for login
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Callback after Facebook login
    public function facebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();

            // Check if the user exists in your database by Facebook ID
            $isUser = User::where('fb_id', $user->id)->first();
               
            if ($isUser) {
                Auth::login($isUser);
                return redirect('/project');
            } else {
                // If the user doesn't exist, create a new user
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'user_name'=>$user->user_name,
                    'fb_id' => $user->id,
                    'password' => bcrypt('admin@123'), 
                ]);
                Auth::login($newUser);
                $newUser->notify(new RegistrationConfirmation());

                return redirect('project');
            }
        } catch (Exception $exception) {
           // dd($exception->getMessage()); 
           return redirect('/project');
        }
    }
}
