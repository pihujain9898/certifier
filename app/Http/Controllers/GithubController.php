<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
class GitHubController extends Controller
{
    public function gitRedirect()
    {
        return Socialite::driver('github')->redirect();
    }
    public function gitCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
            $searchUser = User::where('github_id', $user->id)->first();
            if($searchUser){
                Auth::login($searchUser);
                $arr = ['u_id' => $searchUser->id];
                session($arr);
                return redirect()->intended('/');
            }else{
                $gitUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'oauth_type'=> 'github',
                    'password' => encrypt('nononogitpwd059')
                ]);
                Auth::login($gitUser);
                $arr = ['u_id' => $gitUser->id];
                session($arr);
                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}