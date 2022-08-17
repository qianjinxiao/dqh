<?php

namespace App\Models;

use App\Models\Traits\ProjectCommon;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmergencySupply extends Model
{
	use HasDateTimeFormatter,ProjectCommon;
    protected $table = 'emergency_supplies';
    public static $typeMap=[
        1=>'防止办储备',
        2=>'工管单位储备',
        3=>'社会储备',
    ];
}
