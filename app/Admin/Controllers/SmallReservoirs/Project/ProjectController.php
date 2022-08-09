<?php

namespace App\Admin\Controllers\SmallReservoirs\Project;

use App\Admin\Actions\Traits\TabBase;
use App\Admin\Controllers\InspectStatisticalController;
use App\Admin\Interfaces\TabInterface;
use App\Admin\Renderable\InspectStatistical;
use App\Enum\ProjectEnum;
use App\Models\ProjectInterface;
use App\Models\SmallReservoirs\SmallReservoir;
use Dcat\Admin\Http\Controllers\AdminController;

/**
 * 工程检查
 */
class ProjectController extends AdminController implements TabInterface
{
    use TabBase;
    public $project_type=ProjectEnum::SMALL_RESERVOIR;//第一层tab

    const  STATISTICAL = "statistical";
    const  LOG = "log";
    const  STAFF_CLOCK_IN = "staff_clock_in";
    protected static $tabMap = [
        self::STATISTICAL => "巡查统计",
        self::LOG => "巡查记录",
        self::STAFF_CLOCK_IN => "人员打卡",
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

        }
    }

}
