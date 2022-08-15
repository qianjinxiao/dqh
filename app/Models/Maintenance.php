<?php

namespace App\Models;

use App\Models\Traits\ProjectCommon;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
	use HasDateTimeFormatter,ProjectCommon;
    protected $table = 'maintenance';

}
