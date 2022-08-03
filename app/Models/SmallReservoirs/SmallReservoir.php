<?php

namespace App\Models\SmallReservoirs;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class SmallReservoir extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'small_reservoirs';
    public $guarded=[];
    public static function GetSmallReservoir(){
        return SmallReservoir::query()->get();
    }
}
