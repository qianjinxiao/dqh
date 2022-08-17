<?php

use App\Http\Controllers\Api\V1\ImagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {
    //用户登陆
    Route::post("user/login", [\App\Http\Controllers\Api\V1\UserController::class, 'login']);
    //获取打卡点位
    Route::get("inspect/project_enum", [\App\Http\Controllers\Api\V1\InspectController::class, 'project_enum']);
    //根据点位获取列表
    Route::get("inspect/project/{type}/list", [\App\Http\Controllers\Api\V1\InspectController::class, 'project_list']);

    Route::middleware('auth:api')->group(function () {
        // 上传图片
        Route::post('images', [ImagesController::class, 'store'])
            ->name('images.store');
        //打卡
        Route::post("inspect/clock", [\App\Http\Controllers\Api\V1\InspectController::class, 'clock']);
        //查看最后次打卡轨迹
        Route::get("inspect/clock", [\App\Http\Controllers\Api\V1\InspectController::class, 'show']);
        //绑定设备
        Route::post("emei", [\App\Http\Controllers\Api\V1\ImeisController::class, 'bind']);

        //删除设备
        Route::delete("emei", [\App\Http\Controllers\Api\V1\ImeisController::class, 'un_bind']);

        //我的设备列表
        Route::get("emei", [\App\Http\Controllers\Api\V1\ImeisController::class, 'list']);
        //默认设备
        Route::put("emei/{id}/default", [\App\Http\Controllers\Api\V1\ImeisController::class, 'c_default']);
        Route::prefix('problem')->group(function () {
            //提交反馈
            Route::post("/", [\App\Http\Controllers\Api\V1\ProblemController::class, 'create']);
            //反馈记录
            Route::get("/list", [\App\Http\Controllers\Api\V1\ProblemController::class, 'list']);
            //反馈详情
            Route::get("/{problem}", [\App\Http\Controllers\Api\V1\ProblemController::class, 'show']);

        });
    });
});
