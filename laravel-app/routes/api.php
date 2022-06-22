<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CurrencyApiController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AuthController;

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
// auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('user', [AuthController::class, 'user']);
});

// require authentication..
Route::group(['middleware' => 'auth:sanctum'], function () {
    // api
    Route::group(['prefix' => 'currency'], function () {
        Route::get('list', [CurrencyApiController::class, 'list']);
        Route::get('convert', [CurrencyApiController::class, 'convert']);
        Route::get('change', [CurrencyApiController::class, 'change']);
    });
    // settings
    Route::group(['prefix' => 'setting'], function () {
        Route::get('my', [SettingsController::class, 'list']);
        Route::post('store', [SettingsController::class, 'store']);
        Route::get('my-currencies', [SettingsController::class, 'currencies']);
    });
    // reports
    Route::group(['prefix' => 'report'], function () {
        Route::post('submit', [ReportController::class, 'store']);
        Route::get('my', [ReportController::class, 'my']);
    });
});

Route::middleware('api')->get('/user', function (\Illuminate\Http\Request $request) {
    return $request->header();
});

Route::get('report-types', [ReportController::class, 'types']);
Route::get('report-types2', [ReportController::class, 'types2']);

Route::get('user', [AuthController::class, 'user']);
