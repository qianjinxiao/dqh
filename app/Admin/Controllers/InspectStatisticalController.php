<?php

namespace App\Admin\Controllers;


use App\Models\Inspect\InspectClock;
use App\Models\Inspect\InspectClockData;
use App\Models\Inspect\InspectStatistical;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Services\InspectStatisticalService;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\JsonResponse;
use Illuminate\Http\Request;

class InspectStatisticalController extends BaseAdminController
{
    /**
     * Notes:巡查打卡
     * User: qianjinxiao
     * Date: 2022/8/3
     * Time: 17:14
     * @param Request $request
     * @return JsonResponse|void
     */
    public function statistical(Request $request)
    {
        $data=$request->only(['obj_id','obj_class','clock_date']);
        $res=InspectStatisticalService::getInstance()->statistical(\Admin::user(),$data);
        if($res->getStatusCode()){
            return JsonResponse::make()->success('成功！');
        }
    }

    /**
     * Notes:巡查记录
     * User: qianjinxiao
     * Date: 2022/8/4
     * Time: 17:28
     * @param $id
     * @return Grid
     */
    public function grid_log($class,$id){
        return  Grid::make(InspectClockData::with(['user','startClock','endClock'])->orderBy("id",'desc'), function (Grid $grid) use ($class,$id) {
            $grid->model()->where("project_id", $id)->where("project_type",$class);
            $grid->column('id', 'ID');
            $grid->column('user.name', '巡查人员');
            $grid->column('startClock.time', '巡查时间');
            $grid->column('startClock.water_level', '水位');
            $grid->column('startClock.address', '巡查开始地点');
            $grid->column('endClock.address', '巡查结束地点');
            $grid->column('status', '上报状态')->using(SmallReservoir::$reportMap);
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();

        });
    }
    /**
     * 打卡人员
     */
    public function grid_log_user($class,$id){
        return Grid::make(InspectClock::with(['user']), function (Grid $grid) use ($class,$id) {
            $grid->model()->where("project_id", $id)->where("project_type",$class);
            $grid->column('user.name', '打卡人员');
            $grid->column('time', '打卡时间');
            $grid->column('address', '打卡地点');
            $grid->column('report_status', '状态')->using([0=>'正常',2=>'异常系统自动结束']);
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();

        });
    }
}
