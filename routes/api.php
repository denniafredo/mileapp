<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::controller(PackageController::class)->group(function () {
    Route::get('/packages','index')->name('packages.index');  
    Route::get('/packages/{id}','show')->name('packages.show');  
    Route::post('/packages','store')->name('packages.store');  
    Route::put('/packages/{id}', 'update')->name('packages.update');
    Route::patch('/packages/{id}', 'patch')->name('packages.patch');
    Route::delete('/packages/{id}', 'destroy')->name('packages.destroy');
});

