<?php

namespace App\Models\SmallReservoirs;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class SmallReservoirsUser extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'small_reservoirs_user';
    public $guarded=[];
}
