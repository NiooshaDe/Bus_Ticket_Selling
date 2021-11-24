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
    Route::post('/bus', [\App\Http\Controllers\BusController::class, 'store']);
    Route::put('/bus', [\App\Http\Controllers\BusController::class, 'update']);
    Route::put('/archive', [\App\Http\Controllers\BusController::class, 'archive']);
    Route::get('/bus', [\App\Http\Controllers\BusController::class, 'companyShow']);
    Route::get('/comment', [\App\Http\Controllers\BusController::class, 'addComment']);
});


Route::group(['prefix' => 'ticket', 'namespace' => 'company', 'middleware' => ['permission:company']], function () {
    Route::post('/ticket', [\App\Http\Controllers\TicketController::class, 'store']);
    Route::put('/ticket', [\App\Http\Controllers\TicketController::class, 'update']);
    Route::get('/ticket', [\App\Http\Controllers\TicketController::class, 'show']);
});

//routes related to landing page
Route::prefix('landingShow')->group(function() {
    Route::get('/companies', [\App\Http\Controllers\LandingPageController::class, 'showCompanies']);
    Route::get('/comments', [\App\Http\Controllers\LandingPageController::class, 'showComments']);
    Route::post('/buses', [\App\Http\Controllers\LandingPageController::class, 'showBuses']);
    Route::post('/filter', [\App\Http\Controllers\LandingPageController::class, 'filter']);
});

Route::post('/show', [\App\Http\Controllers\ReserveController::class, 'show']);
