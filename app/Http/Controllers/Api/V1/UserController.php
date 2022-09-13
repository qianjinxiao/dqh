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
use App\Models\Farmland\Farmland;
use App\Models\Inspect\InspectClockData;
use App\Models\Rectification;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\User;
use App\Services\InspectStatisticalService;
use App\Services\UserService;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    public function home(Request $request)
    {
        $date = $request->input('date', '');
        if ($date == '') {
            $m = Carbon::now();
            $m1 = Carbon::now();
        } else {
            $m = Carbon::parse($date);
            $m1 = Carbon::parse($date);
        }
        $start = $m->startOfMonth();
        $end = $m1->addMonth()->startOfMonth();
        $data = InspectClockData::query()->select(DB::raw("CONCAT(YEAR(created_at),'-',MONTH(created_at)) as month,count(id) as day,project_type"))->where(
            "created_at", ">=", $start
        )->where(
            "created_at", "<", $end
        )->where('project_type', '!=', Farmland::class)->groupBy("project_type")->groupBy("month")->get()->each(function ($item) use ($m) {
            $item->name = ProjectEnum::$allTypeMap[$item->project_type];
            $item->days = $m->daysInMonth;
            $item->percent = round($item->day / $item->days * 100, 2) . '%';
            return $item;
        });

        $farmland = InspectClockData::query()->select(DB::raw("count(id) as day,project_type"))->whereBetween(
            "created_at", [Carbon::now()->startOfQuarter()->format("Y-m-d"), Carbon::now()->endOfQuarter()->format("Y-m-d")]
        )->where('project_type', '=', Farmland::class)->groupBy("project_type")->first();
        if ($farmland) {
            $farmland->month = Carbon::now()->startOfQuarter()->format("Y-m") . '/' . Carbon::now()->endOfQuarter()->format("Y-m");
            $farmland->name = ProjectEnum::$allTypeMap[$farmland->project_type];
            $farmland->days = Carbon::now()->startOfQuarter()->diffInDays(Carbon::now()->endOfQuarter());
            $farmland->percent = round($farmland->day / $farmland->days * 100, 2) . '%';
            $farmland = $farmland->toArray();
        } else {
            $farmland = ["month" => Carbon::now()->startOfQuarter()->format("Y-m") . '/' . Carbon::now()->endOfQuarter()->format("Y-m"),
                "day" => 0,
                "project_type" => Farmland::class,
                "name" => ProjectEnum::$allTypeMap[Farmland::class],
                "days" => Carbon::now()->startOfQuarter()->diffInDays(Carbon::now()->endOfQuarter()),
                "percent" => '0%',
            ];
        }

        $data = $data->toArray();
        $arr = [];
        foreach ($data as $k => $v) {
            $arr[$v['project_type']] = $v;
        }
        $newArr = [];
        $f_all_type = array_flip(ProjectEnum::$allTypeMap2);
        foreach (ProjectEnum::$allType as $v) {
            if (isset($arr[$f_all_type[$v]])) {
                $newArr[$v] = $arr[$f_all_type[$v]];
            } else {
                $newArr[$v] = ["month" => Carbon::now()->format("Y-m"),
                    "day" => 0,
                    "project_type" => $f_all_type[$v],
                    "name" => ProjectEnum::$allTypeMap[$f_all_type[$v]],
                    "days" => $m->daysInMonth,
                    "percent" => '0%',
                ];
            }
        }
        $newArr['small_reservoir_and_pool'] = $newArr['small_reservoir'];
        $newArr['small_reservoir_and_pool']['name'] = '水库山塘';
        $newArr['small_reservoir_and_pool']['day'] += $newArr['pool']['day'];
        $newArr['small_reservoir_and_pool']['percent'] = round($newArr['small_reservoir_and_pool']['day'] / $newArr['small_reservoir_and_pool']['days'] * 100, 2) . '%';
        $newArr['farmland'] = $farmland;
        unset($newArr['small_reservoir']);
        unset($newArr['pool']);
        $rectification_count = Rectification::query()->whereBetween('created_at', [Carbon::now()->startOfQuarter()->format("Y-m-d"), Carbon::now()->endOfQuarter()->format("Y-m-d")])->count();
        $newArr['rectification'] = ["month" => Carbon::now()->startOfQuarter()->format("Y-m") . '/' . Carbon::now()->endOfQuarter()->format("Y-m"),
            "day" => $rectification_count,
            "project_type" => "rectification",
            "name" => "整改情况",
            "days" => Carbon::now()->startOfQuarter()->diffInDays(Carbon::now()->endOfQuarter()),
            "percent" =>  round($rectification_count/Carbon::now()->startOfQuarter()->diffInDays(Carbon::now()->endOfQuarter())*100)."%",
        ];
        return $this->success($newArr);
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

    public function mine(Request $request)
    {
        $user = $request->user();
        $u = User::query()->with('project')->find($user->id);
        if (isset($u->project)) {
            $u->project->project_type_name = ProjectEnum::$allTypeMap[$u->project->project_type];
            $u->project->project_type = ProjectEnum::$allTypeMap2[$u->project->project_type];
            $u->project->project_name = ProjectFactory::CreateProject($u->project->project_type)->where('id', $u->project->project_id)->value('name');
        }
        return $this->success($u);
    }

    public function socialStore($type, SocialAuthorizationRequest $request)
    {

        $code = $request->code;
        $app = Factory::miniProgram(config('wechat.mini_program.default'));

        try {
            $oauthUser = $app->auth->session($code);
        } catch (\Exception $e) {
            throw new BusinessException(ResponseEnum::WECHAT_UN_GET_USERINFO);
        }

        if (isset($oauthUser['errcode'])) {
            throw new BusinessException(ResponseEnum::WECHAT_UN_GET_USERINFO);
        }
        switch ($type) {
            case 'wechat':
                $user = User::where('weixin_openid', $oauthUser['openid'])->first();
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

        $code = $request->code;
        $app = Factory::miniProgram(config('wechat.mini_program.default'));
        try {
            $oauthUser = $app->auth->session($code);
        } catch (\Exception $e) {
            throw new BusinessException(ResponseEnum::WECHAT_UN_GET_USERINFO);
        }

        if (isset($oauthUser['errcode'])) {
            throw new BusinessException(ResponseEnum::WECHAT_UN_GET_USERINFO);
        }

        switch ($type) {
            case 'wechat':
                $user = $request->user();
                $user->weixin_openid =$oauthUser['openid'];
                $user->save();
                break;
        }
        return $this->success();
    }
    public function login_out(Request $request){
        $user=$request->user();
        $user->weixin_openid="";
        $user->save();
        auth::logout();
        return $this->success();
    }
}
