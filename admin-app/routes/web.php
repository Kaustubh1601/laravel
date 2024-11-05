<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Models\User;
use Illuminate\Http\Request;

Route::get('/register', [RegistrationController::class, 'start'])->name('user.register');
Route::post('/register', [RegistrationController::class, 'register']);

Route::get('/home', function(){
    return view('home');
});

// Route::get('user/update/{id}', function(){
//     print_r("hello");
//     die;
// });


Route::get('user/view',[RegistrationController::class, 'view']);
Route::post('user/update/{id}', [RegistrationController::class, 'update']);
Route::get('user/delete/{id}', [RegistrationController::class, 'delete']);
Route::get('user/edit/{id}', [RegistrationController::class, 'show']);

Route::get('user/profile', [RegistrationController::class, 'profile']);



