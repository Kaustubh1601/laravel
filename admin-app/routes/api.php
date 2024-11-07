<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/register', [ApiController::class, 'start']);
Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
       Route::get('/user/{id}',[ApiController::class, 'getUser']);
       Route::put('/user/profile/{id}', [ApiController::class, 'update']);
       Route::get('/user/update-password', [ApiController::class, 'passwordForm']);
       Route::post('/user/update-password', [ApiController::class, 'updatePassword']);
});

// Route::put('/user/profile/{id}', function(){
//        print_r("it isworking");
// });
Route::get('/user/profile/{id}',[ApiController::class, 'profile']);

Route::get('/forgot-password', [ApiController::class, 'forgotPassword'])->middleware('guest');

//access reset-pass form
Route::post('/user/reset-password', [ApiController::class, 'resetPasswordLink'])->middleware('guest');
//email, password, password_confirmation

Route::get('/user/reset-password/{token}', [ApiController::class, 'resetPassword'])->name('password.reset');

Route::post('/user/change-password', [ApiController::class, 'changePassword1']);//->middleware('guest');

// Route::post('/user/change-password', function(){
//        print_r("hjhj");die;
// });

Route::get('/dashboard', [ApiController::class, 'dashboard']);

Route::get('/dashboard/adduser', [ApiController::class, 'addUser']);
Route::get('/dashboard/existinguser', [ApiController::class, 'existingUser']);
Route::get('/dashboard/trashlist', [ApiController::class, 'trashlist']);


Route::get('/dashboard/existinguser/edituser/{id}', [ApiController::class, 'editUser']);
Route::post('/dashboard/existinguser/updateuser/{id}', [ApiController::class, 'updateUser']);
Route::get('/dashboard/existinguser/trashuser/{id}', [ApiController::class, 'trashUser']);

Route::get('/dashboard/trashlist/restore/{id}', [ApiController::class, 'restoreUser']);
Route::get('/dashboard/trashlist/delete/{id}', [ApiController::class, 'deleteUser']);


// Client ID: 1
// Client secret: KKa0665JRqSsCBtTvM7pu0IsliuHHu9FJOVlXyHi