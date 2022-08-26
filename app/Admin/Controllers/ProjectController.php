<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Traits\TabBase;
use App\Admin\Interfaces\TabInterface;
use App\Admin\Renderable\InspectStatistical;
use App\Enum\ProjectEnum;
use App\Models\ProjectInterface;

/**
 * 工程检查
 */
class ProjectController extends BaseAdminController implements TabInterface
{
    use TabBase;

    const  STATISTICAL = "statistical";
    const  LOG = "log";
    const  STAFF_CLOCK_IN = "staff_clock_in";
    const  REGIN = "regin";//
    const  LINE = "line";//
    protected static $tabMap = [
        self::STATISTICAL => "巡查统计",
        self::LOG => "巡查记录",
        self::STAFF_CLOCK_IN => "人员打卡",
        self::REGIN => "区域设置",
        self::LINE => "线路设置",
    ];

    public function custom_tab(ProjectInterface $item, string $type)
    {
        switch ($type){
            case self::STATISTICAL:
                return InspectStatistical::make(['id'=>$item->id,'class'=>get_class($item)])->render();
            case self::LOG:
                return (new InspectStatisticalController())->grid_log(get_class($item),$item->id);
            case self::STAFF_CLOCK_IN:
                return (new InspectStatisticalController())->grid_log_user(get_class($item),$item->id);
            case self::REGIN:
                return (new RegionController())->grid(get_class($item),$item->id,1);
            case self::LINE:
                return (new LineController())->grid(get_class($item),$item->id,1);
        }
    }

}
