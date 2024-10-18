<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\SuperSubMenuController;
use App\Http\Controllers\UserController;
use App\Models\SubMenu;
use App\Models\SuperSubMenu;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Block;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', function () {
    return redirect('/dashboardIndi');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    // Route::post('/store', [AuthController::class, 'store'])->name('store');
    Route::post('/', [AuthController::class, 'login']);
});



Route::middleware(['auth'])->group(function () {
    // users
    Route::get('/dashboardIndi', [UserController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);

    // administrator
    // Route::get('/admin', [AdminController::class, 'index'])->middleware('userAkses:administrator');
    Route::get('/dashboardAdmin', [AdminController::class, 'index'])->middleware('userAkses:administrator')->name('dashboardAdmin');
    Route::get('/admin/developer', [AdminController::class, 'developer'])->middleware('userAkses:administrator');

    // developer
    Route::middleware('userAkses:developer')->group(function () {
        Route::get('/dashboardDev', [DeveloperController::class, 'index'])->name('dashboardDev');

        // role
        Route::get('/role', [DeveloperController::class, 'role']);
        Route::post('/storeRole', [RoleController::class, 'store']);
        Route::delete('/deleteRole/{id}', [RoleController::class, 'destroy']);
        Route::get('/role/edit/{id}', [RoleController::class, 'edit']);
        Route::put('/role/update/{id}', [RoleController::class, 'update']);

        // menu
        Route::get('/menu', [MenuController::class, 'index']);
        Route::post('/storeMenu', [MenuController::class, 'store']);
        Route::get('/menu/edit/{id}', [MenuController::class, 'edit']);
        Route::put('/menu/update/{id}', [MenuController::class, 'update']);
        Route::delete('/deleteMenu/{id}', [MenuController::class, 'destroy']);

        // subMenu
        Route::get('/subMenu', [SubMenuController::class, 'index']);
        Route::post('/storeSubMenu', [SubMenuController::class, 'store']);
        Route::get('/SubMenu/edit/{id}', [SubMenuController::class, 'edit']);
        Route::put('/SubMenu/update/{id}', [SubMenuController::class, 'update']);
        Route::delete('/deleteSubMenu/{id}', [SubMenuController::class, 'destroy']);

        // SuperSubMenu
        Route::get('/superSubMenu', [SuperSubMenuController::class, 'index']);
        Route::post('/storeSuperSubMenu', [SuperSubMenuController::class, 'store']);
        Route::get('/SuperSubMenu/edit/{id}', [SuperSubMenuController::class, 'edit']);
        Route::put('/SuperSubMenu/update/{id}', [SuperSubMenuController::class, 'update']);
        Route::delete('/deleteSuperSubMenu/{id}', [SuperSubMenuController::class, 'destroy']);

        // user_access_menus
        Route::get('/userAccessMenu/{id}', [DeveloperController::class, 'useraccessmenu']);
        Route::post('/updateAccessMenu', [DeveloperController::class, 'updateaccessmenu']);
        Route::get('/userAccessSubMenu/{roleId}/{menuId}', [DeveloperController::class, 'useraccesssubmenu']);
        Route::post('/updateAccessSubmenu', [DeveloperController::class, 'updateaccesssubmenu']);
    });

    // Route::get('/admin/developer', [DeveloperController::class, 'developer'])->middleware('userAkses:administrator');

    // member
    Route::get('/dashboardMember', [MemberController::class, 'index'])->middleware('userAkses:member')->name('dashboardMember');
});

Route::get('/block', [AuthController::class, 'block']);
