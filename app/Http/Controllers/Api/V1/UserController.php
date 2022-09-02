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
use App\Factory\ProjectFactory;
use App\Helpers\ApiResponse;
use App\Helpers\ResponseEnum;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\Inspect\InspectClockData;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\User;
use App\Services\InspectStatisticalService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    public function home(Request $request){
        $date=$request->input('date','');
        if($date==''){
            $m=Carbon::now();
            $m1=Carbon::now();
        }else{
            $m=Carbon::parse($date);
            $m1=Carbon::parse($date);
        }
        $start=$m->startOfMonth();
        $end=$m1->addMonth()->startOfMonth();
       $data= InspectClockData::query()->select(DB::raw("CONCAT(YEAR(created_at),'-',MONTH(created_at)) as month,count(id) as day,project_type"))->where(
           "created_at",">=",$start
       )->where(
           "created_at","<",$end
       )->groupBy("project_type")->groupBy("month")->get()->each(function ($item)use ($m){
           $item->name=ProjectEnum::$allTypeMap[$item->project_type];
           $item->month_day=$m->daysInMonth;
           return $item;
       });
        $data=$data->toArray();
        foreach ($data as $k=>$v){
//            $data[$k]['']
        }
        return $this->success($m);
    }
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
            $u->project->project_type_name=ProjectEnum::$allTypeMap[$u->project->project_type];
            $u->project->project_type=ProjectEnum::$allTypeMap2[$u->project->project_type];
            $u->project->project_name=ProjectFactory::CreateProject($u->project->project_type)->where('id', $u->project->project_id)->value('name');
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
