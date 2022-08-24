<?php

namespace App\Workerman;

use App\Exceptions\BusinessException;
use App\Models\Inspect\InspectClockData;
use App\Models\Inspect\InspectLog;
use App\Services\InspectStatisticalService;
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
        $inspect_data_id=InspectLog::query()->where('client_id',$client_id)->value('inspect_data_id');
        $clock_data=InspectClockData::query()->find($inspect_data_id);
        if($clock_data->status==1){
            return;
        }
        $clock_data->status=2;//异常退出
        $clock_data->save();
    }
}
