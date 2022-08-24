<?php

namespace App\Workerman;

use App\Exceptions\BusinessException;
use App\Models\Inspect\InspectClock;
use App\Models\Inspect\InspectClockData;
use App\Models\Inspect\InspectLog;
use App\Services\InspectStatisticalService;
use Carbon\Carbon;
use GatewayWorker\Lib\Gateway;

class Events
{

    public static function onWorkerStart($businessWorker)
    {
    }

    public static function onConnect($client_id)
    {
    }

    public static function onWebSocketConnect($client_id, $data)
    {
    }

    public static function onMessage($client_id, $message)
    {
        $data=json_decode($message,1);
        if(isset($data['type'])){
            switch ($data['type']){
                case "pushAdd"://提交定位
                        $res=InspectStatisticalService::getInstance()->pushAdd($data['data'],$client_id);
                        Gateway::sendToClient($client_id,json_encode($res));
            }
        }

    }

    public static function onClose($client_id)
    {
        $inspect_log=InspectLog::query()->where('client_id',$client_id)->orderBy("id",'desc')->first();
        if($inspect_log){
            $clock_data=InspectClockData::query()->find($inspect_log->inspect_data_id);
            if($clock_data->status==1){
                return;
            }
            $clock= InspectClock::query()->create([
                'time'=>Carbon::now(),
                'user_id'=>$clock_data->user_id,
                'report_status'=>2,//异常
                'project_id'=>$clock_data->project_id,
                'project_type'=>$clock_data->project_type,
                'lat'=>$inspect_log->lat,
                'lon'=>$inspect_log->lon,
            ]);
            $clock_data->end_clock_id=$clock->id;
            $clock_data->status=2;//异常退出
            $clock_data->save();
        }

    }
}
