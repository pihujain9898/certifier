<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialLoginController extends Controller
{
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }
    
    public function callback($provider) {
        try {
            $user = Socialite::driver($provider)->user();
            $finduser = User::where('email', $user->email)->first();
            if ( $finduser ) {
                Auth::login($finduser);
                $arr = ['u_id' => $finduser->id];
                session($arr);
                return redirect()->intended('/');
            } 
            else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'oauth_type'=> $provider,
                    'password' => 'sda$@*f262'
                ]);
                Auth::login($newUser);
                $arr = ['u_id' => $newUser->id];
                session($arr);
                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
