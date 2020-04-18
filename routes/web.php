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

Route::get('/', 'MainController@index');

// 给路由加中间件 用户登录验证
Route::group(['middleware' => 'webAuth'], function () {

    // 路由前缀+命名空间 http://demo.local/shop
    Route::prefix('shop')->namespace('Shop')->group(function () {
        // 在 「App\Http\Controllers\Web\Shop 命名空间下的控制器
        Route::get('/', 'MainController@index');
    });
    
});
