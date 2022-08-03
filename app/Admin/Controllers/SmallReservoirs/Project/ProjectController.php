<?php

namespace App\Admin\Controllers\SmallReservoirs\Project;

use App\Admin\Actions\Traits\TabBase;
use App\Admin\Interfaces\TabInterface;
use App\Models\SmallReservoirs\SmallReservoir;
use Dcat\Admin\Http\Controllers\AdminController;

class ProjectController extends AdminController implements TabInterface
{
    use TabBase;
    const  STATISTICAL = "statistical";
    const  LOG = "log";
    const  STAFF_CLOCK_IN = "staff_clock_in";
    const  REPORT = "report";
    protected static $tabMap = [
        self::STATISTICAL => "巡查统计",
        self::LOG => "巡查记录",
        self::STAFF_CLOCK_IN => "人员打卡",
        self::REPORT => "巡查上报",
    ];

    public function custom_tab(SmallReservoir $item, string $type)
    {
        switch ($type){
            case self::STATISTICAL:
                return 1;
            case self::LOG:
                return 2;
            case self::STAFF_CLOCK_IN:
                return 3;
            case self::REPORT:
                return 4;
        }
    }
}
