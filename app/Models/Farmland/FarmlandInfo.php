<?php

namespace App\Models\Farmland;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class FarmlandInfo extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'farmland_infos';
    protected $guarded=[];

}
