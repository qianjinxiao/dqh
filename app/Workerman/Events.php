<?php

namespace App\Workerman;

use App\Exceptions\BusinessException;
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
        var_dump($data);

        if(isset($data['type'])){
            switch ($data['type']){
                case "pushAdd"://提交定位
                        $res=InspectStatisticalService::getInstance()->pushAdd($data['data']);
                        Gateway::sendToClient($client_id,json_encode($res));
            }
        }

    }

    public static function onClose($client_id)
    {
    }
}
