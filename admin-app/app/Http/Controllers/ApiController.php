<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Route;
Use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class ApiController extends Controller
{
    public function start(){
        //$url = url('/register');
        //return view('registration', compact('url'));
        return ["Result"=>"Please provide your information"];
    }

    public function register(Request $request){

        $request->validate([
            'fname'=>'required|string',
            'lname'=>'string',
            //'age'=> 'required|integer',
            'email'=>'required|email|unique:users,email',
            'dob'=>'nullable',
            'password'=>'required|min:8|confirmed',
            'password_confirmation'=>'required'
        ]);

        $user = new User;
        $user->fname = $request['fname'];
        $user->lname = $request['lname'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user_id = $user->user_id;
        $result = $user->save();

        $token = $user->CreateToken("auth_token")->accessToken;
        return response()->json(
            [
                'token' => $token,
                'user' => $user,
                'message' => 'User created successfully'
            ], 200);
        
            

        // if($result){
        //     return ["Result"=>"Data has been saved", "Data"=>$result];
        // }
        // else{
        //     return ["Result"=>"Operation failed"];
        // }

    }




    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::where(['email'=> $credentials['email']])->first();

        if($user && Hash::check($request->password, $user->password)){
            Auth::login($user);
        }
        else{
            return back()->withErrors(['email' => 'The provided credentials do not match.']);
        }
        $token = $user->createToken("auth_token")->accessToken;
        return response()->json( 
            [
                'token' => $token,
                'user' => $user,
                'message' => 'Logged in successfully',
            ]); 

     }





     public function getUser($id){
        $user = User::find($id);
        
        if(is_null($user)){
            return response()->json(
                [
                    'user' => null,
                    'message' => 'User not found',
                ]);
        }else{
            return response()->json(
                [
                    'user' => $user,
                    'message' => 'User found',
                ]);
        }
     }

    //  public function profile(){
    //     if(Auth::user()){
    //         return [ "message"=>"Please update your profile."];
    //     } else{
    //         return ["message"=>"Please log in first."];
    //     }
        
     //}




     public function update(Request $request){
        $user = Auth::user();

        $request->validate([
            'fname'=> 'required|string',
            'lname'=> 'string',
            'email'=> 'required|email',
            'dob'=> 'required|date',   //date-format:Y-m-d
        ]);

        $user->update([
            'fname'=>$request->input('fname'),
            'lname'=>$request->input('lname'),
            'email'=>$request->input('email'),
            'dob'=>$request->input('dob'),
        ]);

        return response()->json(
            [
                'user'=> $user,
                'message'=> 'Profile updated successfully.',
            ]);
     }



     public function passwordForm(){
        return [
            "Message" => "Enter your old passsword along with new ones."
        ];
     }

     public function updatePassword(Request $request){

            $user = Auth::user();

            if(!Auth::user()){
                return ['message' => 'Unauthenticated'];
            }

            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
                //'new_password_confirmation' => 'required'
            ]);
            
            //dd('old password',($user->password));

           
            if(!Hash::check($request->old_password, auth()->user()->password)){
                //return back()->with('error', "Old password isn't correct");
                return response()->json(
                    [
                        'message' =>'Please enter correct old password.'
                    ]
                    );
            }


            User::where('user_id', auth()->user()->user_id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            //dd('password updated');

            return response()->json(
                [
                    'user' => $user,
                    'message'=> 'Password updated successfully.',
                ]);

     }


     public function forgotPassword(){
        return [ "Message"=>"Please provide your e-mail"];
     }

     public function resetPasswordLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        $status === Password::RESET_LINK_SENT 
                        ? back()->with(['status'=> __($status)])
                        : back()->withErrors(['email'=>__($status)]);

            return [
                "Message" => "Please check your e-mail."
            ];
        
     }


     public function resetPassword(string $token){

        return ["Message" => "Please provide info.",
                'token' => $token
            ];
     }

     public function changePassword1(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation', 'token'),
            function(User $user, string $password){
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

         $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
        if($status){
            return [
                "Message" => "Password updated successfully.",
                'user' => $user
            ];
        } else{
            return [
                "Message" => "Something went wrong."
            ];
        }
        
     }  




///////////////////////////////////// DASHBOARD ////////////////////////////////////////

        public function dashboard(){
            return [
                'message' => 'Welcome to your Dashboard',
            ];
        }


        public function addUser(){
            redirect('/register');

            return[
                'message' => 'Please enter user details',
            ];
        }
            
        public function existingUser(){
            $users = User::all();

            return response()->json(
                [
                    'users' => $users,
                    'message' => 'These are the existing users.'
                ]
                );
        }

        public function trashlist(){
            $users = User::onlyTrashed()->get();

            return response()->json([
                'user' => $users,
                'message' => 'These users are deactivated.'
            ]);
        }



        public function editUser($id){
            $user = User::find($id);

            //$url = url('user/update/')."/".$id;
            $title = 'Update Profile';
            redirect ('/register')->with(compact('title', 'user'));

            return [
                'user' => $user,
                'message' => 'Provide details to update user data.'
            ];
        }

        public function updateUser(Request $request, $id){
            $user = User::findorfail($id);
            dd($user);
            $request->validate([
                'fname' => 'required|string',
                'lname' => 'string',
                'email' => 'required',
                'dob' => 'required|date', //date-format:Y-m-d
            ]);

            $user->update([
                'fname' => $request->input('fname'),
                'lname' => $request->input('lname'),
                'email' => $request->input('email'),
                'dob' => $request->input('dob'),
            ]);

            redirect('/dashboard/existinguser');

            return response()->json([
                'user'=>$user,
                'message'=>'User data updated successfully'
            ]);

        }



        public function trashUser($id){
            $user = User::find($id);
            //dd($user);

            $result = $user->delete();

            if($result){
                redirect('/dashboard/existinguser');
            
                return response->json([
                    'message' => 'User data has been moved to trash.'
                ]);
            }else{
                return [
                    'message' => 'Something went wrong.'
                ];
            }

            return [
                         'user' => $user,
                    ];
            
        }

        public function restoreUser($id){
            $user = User::onlyTrashed()->find($id);

            $result = $user->restore();

            if($result){
                redirect('/dashboard/trashlist');

                return response()->json([
                    'message' => 'User info. has been restored successfully.'
                ]);
            }
            else{
                return [
                    'message' => 'Something went wrong.'
                ];
            }
        }

        public function deleteUser($id){
            $user = User::onlyTrashed()->find($id);

            $result = $user->forceDelete();
            
            if($result){
                redirect('/dashboard/trashlist');

                return response()->json([
                    'message' => 'User info. has been deleted permanently.'
                ]);
            }
            else{
                return [
                    'message' => 'Something went wrong.'
                ];
            }
        }

}


// $ php artisan passport:client --personal
//  What should we name the personal access client? [Laravel Personal Access Client]:
//  > Laravel Personal Access Client
// Personal access client created successfully.
// Client ID: 1
// Client secret: Cjd0nMsNusFTqbdnCyAXunSeBPbPHXlENNAlbf9x