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
    protected $url = 'http://openapi.18gps.net/GetDataService.aspx';

    //注册
    public function Reg(User $user, string $macid, string $fishing_name)
    {
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

    //绑定
    public function bind(User $user, string $macid, string $fishing_name)
    {
        $res = $this->get(http_build_query([
            'method' => 'QueryApi',
            'w' => 'UserBindingDevice',
            'macid' => $macid,
            'mds' => $user->getMds(),
            'nickname'=>$fishing_name
        ]));
        try {
            $data = json_decode($res->body(), 1);
            if ($data['success'] == 'true') {
                UserImei::query()->create([
                    'macid' => $macid,
                    'user_id' => $user->id,
                    'name' => $fishing_name,
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
        $res = $this->get(http_build_query([
            'method' => 'QueryApi',
            'w' => 'UserUnboundDevice',
            'macid' => $macid,
            'mds' => $user->getMds(),
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
    protected function get($param)
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
