<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showLogin(){
        return view('users.login');
    }

    public function showSignup(){
        return view('users.signup');
    }
    
    public function createUser(Request $req){
        $req->validate(
            [
                'name' => 'required|min:2|max:255',
                'email' => 'required|email|unique:users,email|min:6|max:255',
                'password' => 'required|confirmed|min:6|max:255',
                'password_confirmation' => 'required|min:6|max:255'
            ]
        );

        $usr = new User;
        $usr->name = $req['name'];
        $usr->email = $req['email'];
        $usr->oauth_type = "manual";
        $usr->password = md5($req['password']);
        $usr->save();
        $arr = ['u_id' => $usr->id];
        session($arr);
        return redirect("/projects");
    }
    
    public function logout(){
        Session()->flush();
        return redirect('/');
    }

    public function userLogin(Request $req){
        $users=User::all();
        $data = compact('users');

        $req->validate(
            [
                'email' => 'required|email|exists:users,email|min:6',
                'password' => "required|min:6"
            ]
        );
        
        $n=0;
        foreach ($users as $user) {
            if ($user->email == $req->email){
                break;}
            else
                $n=$n+1;
        }

        $pass = $users[$n]->password;
        $req->request->add(['entered_password' => md5($req->password)]);
        $req->request->add(['exisiting_password' => $pass]);

        $req->validate(
            [
                'password' => 'required|min:6',
                'entered_password' => "required|same:exisiting_password"
            ]
        );
        
        $arr = ['u_id' => $users[$n]->id];
        session($arr);
        return redirect("/projects");
    }

    public function showHomePage(){
        if (Session()->has('u_id'))
            return redirect("/projects");
        else
            return view('users.home');
    }
}