<?php

use App\Admin\Controllers\SmallReservoirs\SmallReservoirsInfoController;
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
    $router->group(['prefix' => 'small_reservoirs', 'namespace' => 'SmallReservoirs'], function (Router $router) {
        $router->get('/', [SmallReservoirsInfoController::class, "index"]);//小型水库基础信息
        $router->get('/user/create', [SmallReservoirsInfoController::class, "create_user"]);
        $router->get('/user/{id}/edit', [SmallReservoirsInfoController::class, "edit_user"]);

        $router->post('/', [SmallReservoirsInfoController::class, "update_info"]);
        $router->post('/update_user', [SmallReservoirsInfoController::class, "update_user"]);

    });

    $router->get('/tab_select', [\App\Admin\Controllers\CommonController::class, "tab_select"]);//选项卡切换保存记录

});
