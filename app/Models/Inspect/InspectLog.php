<?php

namespace App\Models\Inspect;

use App\Models\User;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class InspectLog extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'inspect_log';
    public $guarded = [];

    public function inspect_data(){
        return $this->belongsTo(InspectClockData::class,'inspect_data_id');
    }
}
