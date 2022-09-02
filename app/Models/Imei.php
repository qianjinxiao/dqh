<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Imei extends Model
{
    use HasDateTimeFormatter;
    protected $table = 'imeis';
    public $guarded=[];

}
