<?php

namespace App\Models\River;

use App\Models\ProjectInterface;
use App\Models\ProjectUser;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\User;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class River extends Model implements ProjectInterface
{
	use HasDateTimeFormatter;
    protected $table = 'rivers';
    public $guarded=[];
    const SUCCESS = 1;
    const FAIL = 0;
    public static $reportMap = [
        self::SUCCESS => '已清洁',
        self::FAIL => '未清洁',
    ];
    public static function GetList(){
        return River::query()->get();
    }
}
