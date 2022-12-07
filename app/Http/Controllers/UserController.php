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
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'required'
            ]
        );

        $usr = new User;
        $usr->name = $req['name'];
        $usr->email = $req['email'];
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
                'email' => 'required|email|exists:users,email',
                'password' => "required"
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
        $req->request->add(['password_new' => md5($req->password)]);
        $req->request->add(['password_old' => $pass]);

        $req->validate(
            [
                'password_new' => "required|same:password_old"
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