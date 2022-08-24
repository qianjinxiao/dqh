<?php

namespace App\Models\Inspect;

use App\Models\User;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class InspectClockData extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'inspect_data';
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function startClock(){
        return $this->belongsTo(InspectClock::class,'start_clock_id');
    }
    public function endClock(){
        return $this->belongsTo(InspectClock::class,'end_clock_id');
    }
    public function setInspectTableAttribute($value){
        $this->attributes['inspect_table']=json_encode($value);
    }
    public function getInspectTableAttribute($value){
        return json_decode($value,1);
    }
    public static function GetUserLastClock($user,$project){
        $data=InspectClockData::query()->where([
            'user_id'=>$user->id,
            'project_id'=>$project->id,
            'project_type'=>get_class($project)
        ])->orderBy("id","desc")->first();
        if(!$data){
            return false;
        }
        if($data->end_clock_id>0){
            return false;
        }
        return $data;
    }
}
