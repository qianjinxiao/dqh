<?php

namespace App\Models\SmallReservoirs;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class SmallReservoirsInfo extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'small_reservoirs_info';
    public $guarded=[];
}
