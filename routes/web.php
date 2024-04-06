<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/close-previous-session',function(Request $request){
    $sessionId = $request->input('sessionId');
    $ip = $request->ip();
    Cache::forget('session_' . $ip);
    
    // Redirect to wherever you need after closing the previous session
    return redirect('/home')->with('success', 'Previous session closed successfully');
});

Route::post('/continue-current-session',function(){
    return redirect('/home');
});

Route::middleware('checkSession')->get('/home', function (Request $request) {
    return "Welcome to the application";
});


