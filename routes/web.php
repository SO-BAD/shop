<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ManagersController;
use App\Http\Controllers\PagesController;

use App\Http\Middleware\tokenAuth;
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

// Route::get('/', function () {
//     return view('welcome');
// // });
Route::view('/', 'pages.index')->name('index');
Route::view('/login', 'managers.login')->name('loginPage');
Route::post('/login', [ManagersController::class,'login'])->name('login');

Route::view('register', 'managers.register')->name('register');
Route::post('register', [ManagersController::class, 'store']);

Route::group(['middleware' => 'api'], function () {
    
});
    

// Route::get('/logout', [ManagersController::class, 'logout']);
