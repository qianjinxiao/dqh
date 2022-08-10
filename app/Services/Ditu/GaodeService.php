<?php
/**
 *
 * █████▒█    ██  ▄████▄   ██ ▄█▀       ██████╗ ██╗   ██╗ ██████╗
 * ▓██   ▒ ██  ▓██▒▒██▀ ▀█   ██▄█▒        ██╔══██╗██║   ██║██╔════╝
 * ▒████ ░▓██  ▒██░▒▓█    ▄ ▓███▄░        ██████╔╝██║   ██║██║  ███╗
 * ░▓█▒  ░▓▓█  ░██░▒▓▓▄ ▄██▒▓██ █▄        ██╔══██╗██║   ██║██║   ██║
 * ░▒█░   ▒▒█████▓ ▒ ▓███▀ ░▒██▒ █▄       ██████╔╝╚██████╔╝╚██████╔╝
 * ▒ ░   ░▒▓▒ ▒ ▒ ░ ░▒ ▒  ░▒ ▒▒ ▓▒       ╚═════╝  ╚═════╝  ╚═════╝
 * ░     ░░▒░ ░ ░   ░  ▒   ░ ░▒ ▒░
 * ░ ░    ░░░ ░ ░ ░        ░ ░░ ░
 * ░     ░ ░      ░  ░
 * Created by PhpStorm.
 * User: qianjinxiao
 * Date: 2022/8/9
 * Time: 11:16
 */

namespace App\Services\Ditu;

use App\Exceptions\BusinessException;
use App\Helpers\ResponseEnum;
use App\Models\UserImei;
use App\Services\BaseService;
use Illuminate\Support\Facades\Http;

class GaodeService extends BaseService
{
    protected $key="0b3e5442bf9d6ac006003d1ec3040f02";
    public function create_service(){
        $url="https://tsapi.amap.com/v1/track/service/add";
        $res=$this->post($url,[
            "key"=>"0b3e5442bf9d6ac006003d1ec3040f02",
            "name"=>"小程序轨迹",
            "desc"=>'查询小程序实时轨迹'
        ]);
        try {
            $data = json_decode($res->body(), 1);
            dd($data);
        } catch (BusinessException $exception) {
            $this->throwBusinessException(ResponseEnum::SYSTEM_ERROR);
        }
    }
    protected function post($url,$param)
    {
        try {
            dd($param) ;
            $res = Http::withHeaders(["Content-Type"=>"x-www-form-urlencoded"])->post($url , $param);
            return $res;
        } catch (\Exception $e) {
            // 请求失败
            $this->throwBusinessException(ResponseEnum::SYSTEM_ERROR);
        }
    }
}
