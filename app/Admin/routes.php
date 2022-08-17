<?php

use App\Admin\Controllers\CommonController;
use App\Admin\Controllers\InspectStatisticalController;
use App\Admin\Controllers\ProjectController;
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

    $router->get('/info', [\App\Admin\Controllers\ProjectInfoController::class, "index"]);//基础信息
    $router->get('/user/{id}/edit', [\App\Admin\Controllers\ProjectInfoController::class, "edit_user"]);//编辑人员页面
    $router->post('/info', [\App\Admin\Controllers\ProjectInfoController::class, "update_info"]);//创建/修改基础信息
    $router->post('/update_user', [\App\Admin\Controllers\ProjectInfoController::class, "update_user"]);//创建/修改人员方法
    $router->delete('/user/{id}', [\App\Admin\Controllers\ProjectInfoController::class, "delete_user"]);//删除人员
    //工程检查
    $router->resource('/routine_inspections', '\App\Admin\Controllers\ProjectController');//日常巡查
    //调度运行
    $router->resource("/scheduled",'\App\Admin\Controllers\ScheduledController');
    //蓄防水记录
    $router->resource("/water",'\App\Admin\Controllers\WaterController');
    //蓄防水预案
    $router->resource("/water_plan",'\App\Admin\Controllers\WaterPlanController');
    //应急预案
    $router->resource("/emergency_plan",'\App\Admin\Controllers\EmergencyPlanController');
    //防汛物资
    $router->resource("/emergency_supply",'\App\Admin\Controllers\EmergencySupplyController');
    //险情上报
    $router->resource("/emergency_report",'\App\Admin\Controllers\EmergencyReportController');
    //维修养护经费
    $router->resource("/maintenance",'\App\Admin\Controllers\MaintenanceController');
    //维修养护项目
    $router->resource("/maintenance_project",'\App\Admin\Controllers\MaintenanceProjectController');
    //隐患处理
    $router->resource("/maintenance_trouble",'\App\Admin\Controllers\MaintenanceTroubleController');

    //河道
    $router->group(['prefix' => 'river', 'namespace' => 'River'], function (Router $router) {
        $router->get('/', [\App\Admin\Controllers\River\RiverController::class, "index"]);//河道

    });
    $router->resource('/employees', "UserController");//用户
    $router->resource('/employees_imei', "UserImeiController");//用户设备
    $router->resource('/project_user', "ProjectUserController");//关联工作岗位人员
    $router->get('/tab_select', [CommonController::class, "tab_select"]);//选项卡切换保存记录
    $router->post('/inspectStatistical', [InspectStatisticalController::class, "statistical"]);//巡查打卡


});
