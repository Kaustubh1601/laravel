<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    public function start(){
        $url = url('/register');
        return view('registration', compact('url'));
    }

    public function register(Request $request){

        $request->validate([
            'name'=>'required|string',
            'age'=> 'required|integer',
            'email'=>'required|email', //unique: users, email
            'password'=>'required|min:8|confirmed',
            'password_confirmation'=>'required'
        ]);

        $user = new User;
        $user->name = $request['name'];
        $user->age = $request['age'];
        $user->email = $request['email'];
        $user->password = md5($request['password']);
        $user->save();

        $user_id = $user->user_id;
        return view('home', compact('user_id'));

    }


    public function view(Request $request){
        $users = User::all();
        return view('view', compact('users'));
    }

    public function edit($id){
        $user = User::find($id);
        $url = url('user/update/')."/".$id;
        $title = 'Update Profile';
        return view('registration', compact('url','title','user'));
    }

    public function update(Request $request, $id){
        $users = User::findOrfail($id);

        $request->validate([
            'name'=> 'required|string',
            'age'=> 'required|integer',
            'email'=> 'required|email',
        ]);

        $users->update([
            'name'=>$request->input('name'),
            'age'=>$request->input('age'),
            'email'=>$request->input('email'),
        ]);
        
        return redirect()->back();
    }

    public function delete($id){
        User::find($id)->delete();

        return redirect()->back();
    }
}
