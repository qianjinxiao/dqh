<?php

namespace App\Admin\Controllers;


use App\Admin\Renderable\Trajectory;
use App\Models\Inspect\InspectClock;
use App\Models\Inspect\InspectClockData;
use App\Models\Inspect\InspectStatistical;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Services\InspectStatisticalService;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Widgets\Modal;
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
//            $grid->column('log','查看')->expand(function () {
                // 返回打卡详情
                // 这里返回 content 字段内容，并用 Card 包裹起来
//                $card = new Card(null, $this->content);
//
//                return "<div style='padding:10px 10px 0'>$card</div>";
//            });
            $grid->actions(function (Grid\Displayers\Actions $action) {
                $action->append(Modal::make()
                    ->lg()
                    ->title($this->title)
                    ->body(Trajectory::make()->payload(['id' => $this->id, 'type' => 'weixin', 'macid' => $this->macid, 'user_id' => $this->user_id]))
                    ->button("<span class='btn btn-outline-success btn-sm'>轨迹</span>&nbsp;"));
                $id = $this->id;
                $action->append("<a href='/admin/check_nodes?id=$id' class='btn btn-outline-cyan btn-sm'>巡查表</a>");
            });
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
        return Grid::make(InspectClock::with(['user'])->orderBy("id",'desc'), function (Grid $grid) use ($class,$id) {
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
