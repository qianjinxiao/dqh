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

Route::get('/', function () {
//    \App\Services\Ditu\GaodeService::getInstance()->create_service();
//    \App\Models\UserImei::find(1)->delete();
    $a=\App\Services\UserImeiService::getInstance()->routerPass();
    return header("Location:".$a);
});
