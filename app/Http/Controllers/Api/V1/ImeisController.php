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

use App\Helpers\ApiResponse;
use App\Helpers\ResponseEnum;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UserLoginRequest;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\User;
use App\Models\UserImei;
use App\Services\InspectStatisticalService;
use App\Services\UserImeiService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImeisController extends BaseController
{
    public function select(Request $request){
        return $this->successPaginate(DB::table('imeis')->get());
    }
    public function select_bind(Request $request){
        $user = $request->user();
        $imei= DB::table('imeis')->find($request->id);
        if(UserImei::query()->where(['user_id'=>$user->id,'macid'=>$imei->macid])->exists()){
            return $this->fail(ResponseEnum::DEVICE_ACCOUNT_REGISTERED, $data = null, $error=null);
        }
        UserImeiService::getInstance()->loginDevice($user, $imei->macid, $imei->name);
        return $this->success();
    }

    public function list(Request $request)
    {
        $user = $request->user();
        $user_imei = UserImei::query()->where('user_id', $user->id)->paginate();
        return $this->successPaginate($user_imei);
    }

    public function bind(Request $request)
    {
        $user = $request->user();
        $macid = $request->input('macid');
        $fishing_name = $request->input('fishing_name');
        if(UserImei::query()->where(['user_id'=>$user->id,'macid'=>$macid])->exists()){
            return $this->fail(ResponseEnum::DEVICE_ACCOUNT_REGISTERED, $data = null, $error=null);
        }
        UserImeiService::getInstance()->loginDevice($user, $macid, $fishing_name);
        return $this->success();
    }

    public function un_bind(Request $request)
    {
        $user = $request->user();
        $macid = $request->input('macid');
//        UserImeiService::getInstance()->un_bind($user, $macid);
        UserImei::query()->where(['user_id'=>$user->id,'macid'=>$macid])->delete();
        return $this->success();
    }
    public function c_default($id,Request $request){
        UserImei::query()->where(['user_id'=>$request->user()->id])->update(['default'=>0]);
        $ui=UserImei::query()->find($id);
        $ui->default=1;
        $ui->save();
        return $this->success();
    }
}
