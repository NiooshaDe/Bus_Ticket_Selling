<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:passport')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[PassportAuthController::class,'register']);
Route::post('/login',[PassportAuthController::class,'login'])->name('login');
Route::post('/companyRegister',[PassportAuthController::class,'companyRegister']);

Route::group(['prefix' => 'bus', 'namespace' => 'company', 'middleware' => ['permission:company']], function () {
    Route::post('/store', [\App\Http\Controllers\BusController::class, 'store']);
    Route::put('/update', [\App\Http\Controllers\BusController::class, 'update']);
    Route::put('/archive', [\App\Http\Controllers\BusController::class, 'archive']);
    Route::get('/show', [\App\Http\Controllers\BusController::class, 'companyShow']);
});

Route::group(['prefix' => 'ticket', 'namespace' => 'company', 'middleware' => ['permission:company']], function () {
    Route::post('/store', [\App\Http\Controllers\TicketController::class, 'store']);
    Route::put('/update', [\App\Http\Controllers\TicketController::class, 'update']);
    Route::get('/show', [\App\Http\Controllers\TicketController::class, 'show']);
});

Route::middleware(['auth:api', 'permission:company'])->get('/test', function (Request $request) {
    $user = auth('api')->user();//Auth::user();
    dd($user->id);
});

//Route::post('/store', [\App\Http\Controllers\BusController::class, 'store']);
//Route::post('/update', [\App\Http\Controllers\BusController::class, 'update']);
//Route::post('/archive', [\App\Http\Controllers\BusController::class, 'archive']);
//Route::post('/show', [\App\Http\Controllers\BusController::class, 'companyShow']);
