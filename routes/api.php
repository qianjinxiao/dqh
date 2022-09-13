<?php

use App\Http\Controllers\Api\V1\ImagesController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|  Here is where you can register API routes for your application. These
|  routes are loaded by the RouteServiceProvider within a group which
|  is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/home", [\App\Http\Controllers\Api\V1\UserController::class, 'home']);

Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {
    //用户登陆
    Route::post("user/login", [\App\Http\Controllers\Api\V1\UserController::class, 'login']);

    // 第三方登录
    Route::post('socials/{social_type}/authorizations', [UserController::class, 'socialStore'])
        ->where('social_type', 'wechat')
        ->name('socials.authorizations.store');
    //获取打卡点位
    Route::get("inspect/project_enum", [\App\Http\Controllers\Api\V1\InspectController::class, 'project_enum']);
    //根据点位获取列表
    Route::get("inspect/project/{type}/list", [\App\Http\Controllers\Api\V1\InspectController::class, 'project_list']);
    Route::middleware('auth:api')->group(function () {
        //我的信息
        Route::get("mine", [\App\Http\Controllers\Api\V1\UserController::class, 'mine']);
        //推出登陆
        Route::post("user/login_out", [\App\Http\Controllers\Api\V1\UserController::class, 'login_out']);
        Route::post('socials/{social_type}/bind', [UserController::class, 'bind'])
            ->where('social_type', 'wechat')
            ->name('socials.authorizations.bind');
        // 上传图片
        Route::post('images', [ImagesController::class, 'store'])
            ->name('images.store');
        //打卡
        Route::post("inspect/clock", [\App\Http\Controllers\Api\V1\InspectController::class, 'clock']);
        Route::post("inspect/table", [\App\Http\Controllers\Api\V1\InspectController::class, 'table']);
        //打卡每月汇总
        Route::get("inspect/count", [\App\Http\Controllers\Api\V1\InspectController::class, 'count']);
        Route::get("inspect/count_by_day", [\App\Http\Controllers\Api\V1\InspectController::class, 'count_by_day']);
        //查看最后次打卡轨迹
        Route::get("inspect/clock", [\App\Http\Controllers\Api\V1\InspectController::class, 'show']);
        //选择设备列表
        Route::get("emei/list", [\App\Http\Controllers\Api\V1\ImeisController::class, 'select']);
        //我的默认设备
//        Route::get("emei_default", [\App\Http\Controllers\Api\V1\ImeisController::class, 'emei_default']);
        //选择设备绑定
        Route::post("emei/select-bind", [\App\Http\Controllers\Api\V1\ImeisController::class, 'select_bind']);
//        //绑定设备
//        Route::post("emei", [\App\Http\Controllers\Api\V1\ImeisController::class, 'bind']);
//        //删除设备
        Route::delete("emei", [\App\Http\Controllers\Api\V1\ImeisController::class, 'un_bind']);
//        //我的设备列表
//        Route::get("emei", [\App\Http\Controllers\Api\V1\ImeisController::class, 'list']);
//        //默认设备
//        Route::put("emei/{id}/default", [\App\Http\Controllers\Api\V1\ImeisController::class, 'c_default']);
        //获取巡查表线路
        Route::get("line", [\App\Http\Controllers\Api\V1\LineController::class, 'list']);
        //check修改
        Route::put("check/{check}", [\App\Http\Controllers\Api\V1\LineController::class, 'update']);
        //单个check_node 详情
        Route::get("check_node/{check_node}", [\App\Http\Controllers\Api\V1\LineController::class, 'node_show']);
        //单个check_node 修改
        Route::put("check_node/{check_node}", [\App\Http\Controllers\Api\V1\LineController::class, 'node_update']);
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
