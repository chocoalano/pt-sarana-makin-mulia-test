<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Master\RoleController;
use App\Http\Controllers\API\Master\PermissionController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('auth', [AuthController::class, 'auth']);
    Route::post('profil-update', [AuthController::class, 'profileUpdate']);
    Route::post('profil-password', [AuthController::class, 'updatePassword']);
    Route::get('logout', [AuthController::class, 'logout']);
/*
|--------------------------------------------------------------------------
| API Routes MANAGE START
|--------------------------------------------------------------------------
*/
    Route::resource('user', 'App\Http\Controllers\API\Master\UserController');
    Route::resource('role', 'App\Http\Controllers\API\Master\RoleController');
    Route::resource('permission', 'App\Http\Controllers\API\Master\PermissionController');
    Route::resource('barang', 'App\Http\Controllers\API\Master\BarangController');
    Route::resource('permintaan-barang', 'App\Http\Controllers\API\Master\PermintaanBarangController');
    /*
    |--------------------------------------------------------------------------
    | API Routes MANAGE END
    |--------------------------------------------------------------------------
    */
    Route::get('get-roles-item', [RoleController::class, 'getrolesitem']);
    Route::get('get-permission-item', [PermissionController::class, 'getpermissionitem']);
});
