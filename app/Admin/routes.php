<?php

use App\Admin\Controllers\CommonController;
use App\Admin\Controllers\InspectStatisticalController;
use App\Admin\Controllers\ProjectUserController;
use App\Admin\Controllers\SmallReservoirs\Project\ProjectController;
use App\Admin\Controllers\SmallReservoirs\SmallReservoirsInfoController;
use Dcat\Admin\Http\Controllers\UserController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    //小型水库
    $router->group(['prefix' => 'small_reservoirs', 'namespace' => 'SmallReservoirs'], function (Router $router) {
        $router->get('/', [SmallReservoirsInfoController::class, "index"]);//小型水库基础信息
        $router->get('/user/{id}/edit', [SmallReservoirsInfoController::class, "edit_user"]);//编辑人员页面
        $router->post('/', [SmallReservoirsInfoController::class, "update_info"]);//创建/修改基础信息
        $router->post('/update_user', [SmallReservoirsInfoController::class, "update_user"]);//创建/修改人员方法
        $router->delete('/user/{id}', [SmallReservoirsInfoController::class, "delete_user"]);//删除人员
        //工程检查
        $router->group(['prefix' => 'project', 'namespace' => 'Project'], function (Router $router) {
            $router->get('/routine_inspections', [ProjectController::class, "index"]);//小型水库基础信息
        });
    });
    //河道
    $router->group(['prefix' => 'river', 'namespace' => 'River'], function (Router $router) {
        $router->get('/', [\App\Admin\Controllers\River\RiverController::class, "index"]);//河道

    });
    $router->resource('/employees', "UserController");//用户
    $router->resource('/project_user',"ProjectUserController");//关联工作岗位人员
    $router->get('/tab_select', [CommonController::class, "tab_select"]);//选项卡切换保存记录
    $router->post('/inspectStatistical', [InspectStatisticalController::class, "statistical"]);//巡查打卡

});
