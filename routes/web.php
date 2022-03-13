<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ManagersController;
use App\Http\Controllers\MenusController;
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
Route::post('/login', [ManagersController::class, 'login'])->name('login');

Route::get('/logout', [ManagersController::class, 'logout'])->name('logout');



Route::post('register', [ManagersController::class, 'store']);

Route::group(['middleware' => 'session'], function () {
    
    Route::view('register', 'managers.register')->name('register');
    Route::view('/login', 'managers.login')->name('loginPage');
    // Route::get('/login',function(){
    //     return view('managers.login');
    // })->name('loginPage');
    Route::get('addMenuPage', function () {
        return view("menus.addMenu");
    })->name("addMenuPage");
});

Route::group(['middleware' => 'protected'], function () {
    Route::post('addMenu', [MenusController::class, 'store'])->name("addMenu");
});
