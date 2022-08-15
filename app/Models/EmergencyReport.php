<?php

namespace App\Models;

use App\Models\Traits\ProjectCommon;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class EmergencyReport extends Model
{
	use HasDateTimeFormatter,ProjectCommon;
    protected $table = 'emergency_report';

}
