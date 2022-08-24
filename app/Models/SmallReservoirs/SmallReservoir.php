<?php

namespace App\Models\SmallReservoirs;

use App\Models\ProjectInterface;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class SmallReservoir extends Model implements ProjectInterface
{
	use HasDateTimeFormatter;
    protected $table = 'small_reservoirs';
    public $guarded=[];
    const SUCCESS = 1;
    const FAIL = 0;
    const ERROR = 2;
    public static $reportMap = [
        self::SUCCESS => '已巡查',
        self::FAIL => '未巡查',
        self::ERROR => '异常结束',
    ];
    public static function GetList(){
        return SmallReservoir::query()->get();
    }

}
