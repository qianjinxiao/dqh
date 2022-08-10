<?php

namespace App\Admin\Controllers\River;

use App\Admin\Actions\Traits\TabBase;
use App\Admin\Interfaces\TabInterface;
use App\Admin\Renderable\Trajectory;
use App\Enum\ProjectEnum;
use App\Models\Inspect\InspectClockData;
use App\Models\ProjectInterface;
use App\Models\River\River;

use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Modal;

/**
 * 河道保洁
 */
class RiverController extends AdminController implements TabInterface
{
    use TabBase;

    public $project_type=ProjectEnum::RIVER;//第一层tab
    //第二层
    const RIVER='river';
    protected static $tabMap = [
        self::RIVER=>'河道保洁'
    ];
    public function custom_tab(ProjectInterface $item, string $type)
    {
        switch ($type){
            case self::RIVER:
                return $this->gird($item);
        }
    }
    public function gird(ProjectInterface $item){
        \Admin::js('/ditu/ditu.js');
        \Admin::js('https://webapi.amap.com/ui/1.1/main.js?v=1.1.1');

        return Grid::make(InspectClockData::with(['user','startClock','endClock'])->orderBy("id",'desc'), function (Grid $grid) use ($item) {
            $grid->model()->where("project_id", $item->id)->where("project_type",get_class($item));
            $grid->column('user.name', '清洁人员');
            $grid->column('startClock.time', '清洁时间');
            $grid->column('startClock.address', '清洁起点');
            $grid->column('endClock.address', '清洁终点');
            $grid->column('status', '上报状态')->using(River::$reportMap);
            $grid->actions(function (Grid\Displayers\Actions $action){
                $action-> append( Modal::make()
                    ->lg()
                    ->title($this->title)
                    ->body(Trajectory::make()->payload(['id'=>$this->id,'type'=>'GPS','macid'=>$this->macid,'user_id'=>$this->user_id]))
                    ->button("轨迹"));
            });
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();

        });
    }
}
