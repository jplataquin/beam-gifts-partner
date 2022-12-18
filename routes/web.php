<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/scan', [App\Http\Controllers\HomeController::class, 'scan'])->name('scan');
    Route::get('/claim/{uid}', [App\Http\Controllers\ClaimController::class, 'index']);
    Route::post('/claim', [App\Http\Controllers\ClaimController::class, 'claim']);
   
});


Route::get('/qr-scanner.min.js', function(){

    $response = Response::make(File::get(base_path('node_modules/qr-scanner/qr-scanner.min.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;
});



Route::get('/qr-scanner-worker.min.js', function(){

    $response = Response::make(File::get(base_path('node_modules/qr-scanner/qr-scanner-worker.min.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;
});


Route::get('adarna.js', function(){

    $response = Response::make(File::get(base_path('node_modules/adarna/dist/adarna.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;
});


Route::get('adarna.js', function(){

    $response = Response::make(File::get(base_path('node_modules/adarna/dist/adarna.js')), 200);
    $response->header("Content-Type", 'text/javascript');

    return $response;
});