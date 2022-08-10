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
 * Date: 2022/8/3
 * Time: 16:54
 */

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Helpers\ResponseEnum;
use App\Models\User;
use App\Models\UserImei;
use Illuminate\Support\Facades\Http;

class UserImeiService extends BaseService
{
    protected $url;

    //注册
    public function Reg(User $user, string $macid, string $fishing_name)
    {
        $this->url = 'http://openapi.18gps.net/GetDataService.aspx';
        $res = $this->get(http_build_query([
            'method' => 'SignApi',
            'w' => 'UserRegister',
            'macid' => $macid,
            'userName' => $user->username,
            'password' => $user->password,
        ]));
        if ($data = $res->body()) {
            $data = json_decode($data, 1);
            if (isset($data['success'])) {
                if ($data['success'] == 'true') {
                    UserImei::query()->firstOrCreate([
                        'macid' => $macid,
                        'user_id' => $user->id,
                        'name' => $fishing_name
                    ], [
                        'macid' => $macid,
                        'user_id' => $user->id,
                        'name' => $fishing_name
                    ]);
                } else {
                    $this->throwBusinessException([$data['errorCode'], $data['errorDescribe']]);
                }
                $this->throwBusinessException(ResponseEnum::SYSTEM_ERROR);
            }

        }
    }

    //登陆
    public function Login(User $user)
    {
        $this->url = 'http://openapi.18gps.net/GetDataService.aspx';
        $res = $this->get(http_build_query([
            'method' => 'SignApi',
            'w' => 'UserLogin',
            'userName' => $user->username,
            'password' => $user->password,
        ]));
        if ($data = $res->body()) {
            $data = json_decode($data, 1);
            if (isset($data['success'])) {
                if ($data['success'] == 'true') {
                    $user->mds = $data['data']['mds'];
                } else {
                    $this->throwBusinessException([$data['errorCode'], $data['errorDescribe']]);
                }
                $this->throwBusinessException(ResponseEnum::SYSTEM_ERROR);
            }

        }
    }

    //绑定
    public function bind(User $user, string $macid, string $fishing_name)
    {
        $this->url = "http://openapi.18gps.net/GetDataService.aspx";
        $res = $this->get(http_build_query([
            'method' => 'QueryApi',
            'w' => 'UserBindingDevice',
            'macid' => $macid,
            'mds' => $user->mds,
            'nickname' => $fishing_name
        ]));
        try {
            $data = json_decode($res->body(), 1);
            if ($data['success'] == 'true') {
                if (UserImei::query()->where(['user_id' => $user->id, 'default' => 1])->exists()) {
                    $default = 0;
                } else {
                    $default = 1;
                }
                UserImei::query()->create([
                    'macid' => $macid,
                    'user_id' => $user->id,
                    'name' => $fishing_name,
                    'default' => $default
                ]);
            } else {
                $this->throwBusinessException([$data['errorCode'], $data['errorDescribe']]);
            }
        } catch (BusinessException $exception) {
            $this->throwBusinessException(ResponseEnum::SYSTEM_ERROR);
        }

    }

    //解绑
    public function un_bind(User $user, string $macid)
    {
        $this->url = "http://openapi.18gps.net/GetDataService.aspx";
        $res = $this->get(http_build_query([
            'method' => 'QueryApi',
            'w' => 'UserUnboundDevice',
            'macid' => $macid,
            'mds' => $user->mds,
        ]));
        try {
            $data = json_decode($res->body(), 1);
            if ($data['success'] == 'true') {
                UserImei::query()->where([
                    'macid' => $macid,
                    'user_id' => $user->id,
                ])->delete();
            } else {
                $this->throwBusinessException([$data['errorCode'], $data['errorDescribe']]);
            }
        } catch (BusinessException $exception) {
            $this->throwBusinessException(ResponseEnum::SYSTEM_ERROR);
        }

    }

    //轨迹
    public function routerPass($macid, $mds)
    {
        $this->url = 'http://openapi.18gps.net/RouterPass.ashx';

        $param = http_build_query([
            'method' => 'Playback',
            "mds" => $mds,
            'macid' => $macid,
            'url' => 'http://www.18gps.net/',
        ]);
        return $this->url . '?' . $param;
    }

    //获取当前定位
    public function location(User $user, string $macid)
    {
        $this->url = "http://openapi.18gps.net/GetDataService.aspx";
        $res = $this->get(http_build_query([
            'method' => 'QueryApi',
            'w' => 'Location',
            'macid' => $macid,
            'mds' => $user->mds,
        ]));
        $data = json_decode($res->body(), 1);
        if ($data['success'] != 'true') {
           $this->throwBusinessException([$data['errorCode'], $data['errorDescribe']]);
        }
        return $data['data'];
    }

    public function decode_address($lat, $lon)
    {
        $this->url = "https://restapi.amap.com/v3/geocode/regeo";
        $res = $this->get(http_build_query([
            'key' => '0b3e5442bf9d6ac006003d1ec3040f02',
            'location' => "$lon,$lat",
        ]));
        try {
            $data = json_decode($res->body(), 1);
            if ($data['status'] == 1) {
                return $data['regeocode']['formatted_address'];
            } else {
                $this->throwBusinessException([$data['status'], $data['info']]);

            }
        } catch (BusinessException $exception) {
            $this->throwBusinessException(ResponseEnum::SYSTEM_ERROR);
        }
    }

    protected function get($param = '')
    {
        try {
            $res = Http::get($this->url . '?' . $param);
            return $res;
        } catch (\Exception $e) {
            // 请求失败
            $this->throwBusinessException(ResponseEnum::SYSTEM_ERROR);
        }
    }
}
