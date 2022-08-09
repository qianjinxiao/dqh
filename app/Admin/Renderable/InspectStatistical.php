<?php

namespace App\Admin\Renderable;

use App\Models\SmallReservoirs\SmallReservoirsUser;
use Dcat\Admin\Support\LazyRenderable;
use Illuminate\Support\Carbon;

class InspectStatistical extends LazyRenderable
{
    public static $js = [
        '/jquerycalendar/js/calendar/jquery.min.js',
        '/jquerycalendar/js/calendar/calendar.js'
    ];
    public static $css=[
        '/jquerycalendar/css/Calendar.css'
    ];
    public function render()
    {

        $id = $this->id;
        $class=$this->class;
        $now_date=request("now_date")??Carbon::now()->format("Y-m-d");
        $list=\App\Models\Inspect\InspectStatistical::query()->byProject($class,$id)->clock()->pluck("clock_date")->toArray();
        foreach ($list as &$v){
            $v=Carbon::parse($v)->format("Y-m-d");
        }
        $start=Carbon::parse($now_date)->subMonth()->lastOfMonth();
        $date=[];
        for ($i=0;$i<Carbon::parse($now_date)->daysInMonth;$i++){
            $d=$start->addDay()->format("Y-m-d");
            $date[$i]["startDate"]=$d;
            if(in_array($d,$list)){
                $date[$i]["name"]='已巡查';
                $date[$i]["status"]=1;
            }else{
                $date[$i]["name"]='未巡查';
                $date[$i]["status"]=0;
            }
        }
        return view('inspect_statistical',["id"=>$id,'date'=>urlencode(json_encode($date)),'now_date'=>$now_date]);
        // TODO: Implement render() method.
    }
}
