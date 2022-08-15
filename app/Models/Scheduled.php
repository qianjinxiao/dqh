<?php

namespace App\Models;

use App\Models\Traits\ProjectCommon;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Scheduled extends Model
{
	use HasDateTimeFormatter,ProjectCommon;
    protected $table = 'scheduled';
    public static $typeMap=[
        1=>'报批稿',
        2=>'批复稿',
    ];

    public function admin(){
        return $this->belongsTo(Administrator::class,'admin_id');
    }
}
