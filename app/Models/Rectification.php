<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Rectification extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'rectification';
    public $guarded=[];
}
