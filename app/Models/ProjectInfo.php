<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class ProjectInfo extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'project_info';
    public $guarded=[];
}
