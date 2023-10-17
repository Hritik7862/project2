<?php
  
namespace App\Http\Controllers;
use Mail;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Notifications\RegistrationConfirmation;

  
class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
        
    }
          
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->user();

        $finduser = User::where('gauth_id', $user->id)->first();

        if ($finduser) {
            Auth::login($finduser);
            return redirect()->intended('project');
        } else {
            // Check if the required fields are available in the Google user object
            $userData = [
                'email' => $user->email,
                'name' => $user->name,
                'gauth_id' => $user->id,
                'password' => encrypt('123456dummy')
            ];

            if (isset($user->user_name)) {
                $userData['user_name'] = $user->user_name;
            }

            if (isset($user->mobile)) {
                $userData['mobile'] = $user->mobile;
            }
            $newUser = User::create($userData);
            $newUser->notify(new RegistrationConfirmation());

            Auth::login($newUser);
            return redirect()->intended('project');
        }
    } catch (Exception $e) {
        dd($e->getMessage());
    }
}

}
