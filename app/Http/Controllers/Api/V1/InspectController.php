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
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\InspectClockRequest;
use App\Models\Inspect\InspectClock;
use App\Models\Inspect\InspectClockData;
use App\Models\ProjectUser;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\User;
use App\Services\InspectStatisticalService;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use GatewayWorker\Lib\Db;
use Illuminate\Http\Request;

class InspectController extends BaseController
{
    public function clock(InspectClockRequest $request){
        $user=$request->user();
        $data=$request->only('lat','lon','address','macid');

        $model=InspectStatisticalService::getInstance()->clock($user,$request->input('project_type'),$request->project_id,$data);
        $map= array_flip(ProjectEnum::$allTypeMap2);
        $type=$map[$request->input('project_type')];
        ProjectUser::create([
           'user_id'=>$user->id,
           'project_id'=>$request->project_id,
           'project_type'=>$type
        ]);
        return $this->success($model);
    }
    public function show(Request $request){
        $user=$request->user();
        $data=InspectStatisticalService::getInstance()->show($user);
        return $this->success(['username'=>$user->name,'data'=>$data]);
    }
    public function project_enum(Request $request){
        return $this->success(ProjectEnum::$project_list);
    }
    public function project_list(string $type,Request $request){
        $list=InspectStatisticalService::getInstance()->project_list($type);
        return $this->successPaginate($list);
    }
    public function count(Request $request){
        $month=$request->input('month',Carbon::now()->format("Y-m-d"));
        $return['shoud_clock']=Carbon::now()->daysInMonth;
        $return['clock']=InspectClockData::query()->select(\Illuminate\Support\Facades\DB::raw("count(distinct(DATE_FORMAT(created_at, '%d/%m/%Y'))) as count"))->whereBetween('updated_at',[Carbon::parse($month)->startOfMonth(),Carbon::parse($month)->endOfMonth()])->where(['status'=>1,'user_id'=>$request->user()->id])->value('count');
        $return['un_clock']=$return['shoud_clock']-$return['clock'];
        return $this->success($return);
    }
    public function count_by_day(Request $request){
        $date=$request->input('date',Carbon::now()->format("Y-m-d"));
       $data=InspectClockData::query()->whereDate('updated_at',$date)->orderBy("id",'desc')->where(['status'=>1,'user_id'=>$request->user()->id])->first();
       if($data){
           $return['start_clock']=InspectClock::query()->select('time','address')->find($data['start_clock_id']);
           $return['start_clock']->time=Carbon::parse($return['start_clock']->time)->timestamp;
           $return['end_clock']=InspectClock::query()->select('time','address')->find($data['end_clock_id']);
           $return['end_clock']->time=Carbon::parse($return['end_clock']->time)->timestamp;

       }else{
           $return['start_clock']=null;
           $return['end_clock']=null;
       }

        return $this->success($return);
    }
    public function table(Request $request){
        $table=$request->input('table');
        $inspect_data_id=$request->input('inspect_data_id');
        $data=InspectClockData::query()->find($inspect_data_id);
        $data->inspect_table=$table;
        $data->save();
        return $table-$this->success();
    }
}
