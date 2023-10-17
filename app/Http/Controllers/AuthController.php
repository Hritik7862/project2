<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Http\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
   { //
    protected function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($data['mobile'], "sms");
        User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
        return redirect()->route('verify')->with(['mobilr' => $data['mobile']]);
    }
    protected function verify(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'mobile' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['mobile']));
        if ($verification->valid) {
            $user = tap(User::where('mobile', $data['mobile']))->update(['isVerified' => true]);
            /* Authenticate user */
            Auth::login($user->first());
            return redirect()->route('home')->with(['message' => 'Phone number verified']);
        }
        return back()->with(['mobile' => $data['mobile'], 'error' => 'Invalid verification code entered!']);
    }

   }