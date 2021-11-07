<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/registered', [RegisterController::class, 'store']);

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function() {
    return view('login');
});

Route::post('/loggedIn', [LoginController::class, 'authenticate']);

//\Illuminate\Support\Facades\Auth::routes();
//
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('dashboard', function(){
    echo "done";
});
