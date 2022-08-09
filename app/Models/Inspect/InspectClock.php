<?php

namespace App\Models\Inspect;

use App\Models\User;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class InspectClock extends Model
{
    //设定巡查打卡数
    protected $clock_num = 2;
    use HasDateTimeFormatter;


    protected $table = 'inspect_clock';
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::created(function (InspectClock $inspectClock) {
            //记录已巡查
            if ($inspectClock->checkStatistical()) {
                InspectStatistical::create([
                    'project_id' => $inspectClock->project_id,
                    'project_type' => $inspectClock->project_type,
                    'clock_date' => $inspectClock->time,
                    'status' => InspectStatistical::CLOCK,
                    'user_id' => $inspectClock->user_id
                ]);
            }
        });
    }

    //获取同类型同一天的数量是否大于2
    public function checkStatistical()
    {
        $num = InspectClock::query()->where(['project_type' => $this->project_type])->whereDay("time", $this->time)->count();
        if ($num >= $this->clock_num && !InspectStatistical::type($this->project_type)->whereDay("clock_date", $this->time)->exists()) {
            return true;
        }
        return false;
    }
}
