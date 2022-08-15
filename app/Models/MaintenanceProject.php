<?php

namespace App\Models;

use App\Models\Traits\ProjectCommon;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class MaintenanceProject extends Model
{
	use HasDateTimeFormatter,ProjectCommon;
    protected $table = 'maintenance_project';
    public static $typeMap=[
        1=>'年度维修',
        2=>'日常维修'
    ];
}
