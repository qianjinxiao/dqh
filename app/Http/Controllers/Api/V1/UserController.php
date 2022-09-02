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
 * Date: 2022/8/4
 * Time: 21:20
 */

namespace App\Http\Controllers\Api\V1;

use App\Enum\ProjectEnum;
use App\Exceptions\BusinessException;
use App\Helpers\ApiResponse;
use App\Helpers\ResponseEnum;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\User;
use App\Services\InspectStatisticalService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function login(UserLoginRequest $request)
    {
        $username = $request->username;
        $password = $request->password;
        $user = UserService::getInstance()->login($username, $password);
        $token = auth('api')->login($user);
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
    public function mine(Request $request){
        $user=$request->user();
        $u=User::query()->with('project')->find($user->id);
        if(isset($u->project)){
            $u->project->project_type=ProjectEnum::$allTypeMap2[$u->project->project_type];
        }
        return $this->success($u);
    }
    public function socialStore($type, SocialAuthorizationRequest $request)
    {
        $driver = \Socialite::create($type);

        try {
            if ($code = $request->code) {
                $oauthUser = $driver->userFromCode($code);
            } else {
                // 微信需要增加 openid
                if ($type == 'wechat') {
                    $driver->withOpenid($request->openid);
                }

                $oauthUser = $driver->userFromToken($request->access_token);
            }
        } catch (\Exception $e) {
            throw new BusinessException(ResponseEnum::WECHAT_UN_GET_USERINFO);
        }

        if (!$oauthUser->getId()) {
            throw new BusinessException(ResponseEnum::WECHAT_UN_GET_USERINFO);
        }

        switch ($type) {
            case 'wechat':
                $unionid = $oauthUser->getRaw()['unionid'] ?? null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    throw new BusinessException(ResponseEnum::WECHAT_UNBIND);
                }
                break;
        }
        $token = auth('api')->login($user);
        return $this->respondWithToken($token);
    }
    public function bind($type, SocialAuthorizationRequest $request)
    {
        $driver = \Socialite::create($type);

        try {
            if ($code = $request->code) {
                $oauthUser = $driver->userFromCode($code);
            } else {
                // 微信需要增加 openid
                if ($type == 'wechat') {
                    $driver->withOpenid($request->openid);
                }
                $oauthUser = $driver->userFromToken($request->access_token);
            }
        } catch (\Exception $e) {
            throw new BusinessException(ResponseEnum::WECHAT_UN_GET_USERINFO);
        }

        if (!$oauthUser->getId()) {
            throw new BusinessException(ResponseEnum::WECHAT_UN_GET_USERINFO);
        }

        switch ($type) {
            case 'wechat':
                $unionid = $oauthUser->getRaw()['unionid'] ?? null;
                $user=$request->user();
                if ($unionid) {
                    $user->weixin_unionid=$unionid;
                    $user->weixin_openid=$oauthUser->getId();

                } else {
                    $user->weixin_openid=$oauthUser->getId();
                }
                $user->save();
                break;
        }

        return $this->success();
    }

}
