<?php

namespace App\Models\Inspect;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class InspectStatistical extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'inspect_statistical';
    public $guarded=[];
    const CLOCK=1;
    const NONE=0;
    public function obj()
    {
        return $this->morphTo();
    }
    public function scopeByProject($query,$class,$id)
    {
        return $query->type($class)->where('project_id', $id);
    }
    public function scopeType($query,$class)
    {
        return $query->where('project_type', $class);
    }
    public function scopeClock($query){
        return $query->where('status', self::CLOCK);
    }
    public function getClockFirst(){
        return InspectClock::query()->where(['user_id'=>$this->user_id,'project_id'=>$this->project_id,'project_type'=>$this->project_type])->whereDay('time',$this->clock_date)
            ->orderBy("id","asc")->first();
    }
    public function getClockEnd(){
        return InspectClock::query()->where(['user_id'=>$this->user_id,'project_id'=>$this->project_id,'project_type'=>$this->project_type])->whereDay('time',$this->clock_date)
            ->orderBy("id","desc")->first();
    }
}
