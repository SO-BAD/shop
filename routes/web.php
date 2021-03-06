<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ManagersController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\PagesController;

use App\Http\Middleware\tokenAuth;
use App\Models\MenuItems;

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



Route::get('/logout', [ManagersController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'session'], function () {
    
    Route::post('/login', [ManagersController::class, 'login'])->name('login');
    Route::post('register', [ManagersController::class, 'store']);
    Route::view('register', 'managers.register')->name('register');
    Route::view('/login', 'managers.login')->name('loginPage');
    // Route::get('/login',function(){
    //     return view('managers.login');
    // })->name('loginPage');

    
    Route::get('showOnMenuPage', [MenusController::class,'showOnMenus'])->name("showOnMenuPage");
    Route::get('addMenuPage', function () {
        return view("menus.addMenu");
    })->name("addMenuPage");
    Route::get('editMenuPage', [MenusController::class,'showMenus'])->name("editMenuPage");
    Route::get('delCategoryPage', [MenusController::class,'showCategories'])->name("delCategoryPage");


    Route::get('editItemPage', [MenusController::class,'showItems'])->name("editItemPage");
});

Route::group(['middleware' => 'protected'], function () {
    Route::post('addMenu', [MenusController::class, 'store'])->name("addMenu");
    Route::post('editMenu', [MenusController::class, 'edit'])->name("editMenu");
    Route::post('delCategory', [MenusController::class, 'del'])->name("delCategory");
    
    Route::get('getOnMenus', [MenusController::class,'getOnMenus'])->name("getOnMenus");
    
    Route::post('delItem', [MenusController::class, 'delItem'])->name("delItem");
    Route::post('showItem', [MenusController::class, 'showItem'])->name("showItem");
    Route::post('editItem', [MenusController::class, 'editItem'])->name("editItem");
    Route::post('editItemSh', [MenusController::class, 'editItemSh'])->name("editItemSh");
});
