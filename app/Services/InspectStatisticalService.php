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

use App\Enum\ProjectEnum;
use App\Exceptions\BusinessException;
use App\Factory\ProjectFactory;
use App\Helpers\ResponseEnum;
use App\Models\Check;
use App\Models\CheckNode;
use App\Models\Imei;
use App\Models\Inspect\InspectClock;
use App\Models\Inspect\InspectClockData;
use App\Models\Inspect\InspectLog;
use App\Models\Inspect\InspectStatistical;
use App\Models\Line;
use App\Models\ProjectInterface;
use App\Models\User;
use App\Models\UserImei;
use Carbon\Carbon;
use GatewayWorker\Lib\Db;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Static_;

class InspectStatisticalService extends BaseService
{
    //使用gps的类型
    protected static $gps_type = [
        ProjectEnum::RIVER
    ];

    /**
     * Notes:打卡
     * User: qianjinxiao
     * Date: 2022/8/4
     * Time: 21:10
     */
    public function clock(User $user, string $type, int $id, $data)
    {
        //获取工厂
        $project = ProjectFactory::CreateProject($type);
        if (!$project instanceof ProjectInterface) {//单纯只是为了下面代码有指引
            $this->throwBusinessException();
        }

//        try {
            $clock_data= \Illuminate\Support\Facades\DB::transaction(function ()use($project,$id,$data,$user,$type) {

                //查询对象
                $projectModel = $project->where('id', $id)->first();
                if (!in_array($type, self::$gps_type)) {
                    $lat = $data['lat'];
                    $lon = $data['lon'];
                    $address = $data['address'];
                } else {
                    $mds=Imei::query()->where("macid", $user->macid)->value('mds');
                    $device_info = UserImeiService::getInstance()->location($mds, $user->macid);
                    $lat = $device_info['lat'];
                    $lon = $device_info['lon'];
                    if(isset($device_info['device_status'])){
                        if($device_info['device_status'][0]==0){
                            throw new BusinessException(['300001','设备未打开']);
                        }
                        if($device_info['device_status'][5]==0){
                            throw new BusinessException(['300001','设备未定位']);
                        }
                    }
                    $address = UserImeiService::getInstance()->decode_address($lat, $lon);
                }
                $model = InspectClock::create([
                    'user_id' => $user->id,
                    'project_id' => $projectModel->id,
                    'project_type' => get_class($projectModel),
                    'address' => $address,
                    'lat' => $lat,
                    'lon' => $lon,
                    'device_info' => json_encode($device_info ?? []),
                    'time' => Carbon::now(),
                    'water_level' => $data['water_level'] ?? '',
                    'report_status' => $data['report_status'] ?? 0,
                ]);

                if (!$clock_data = InspectClockData::GetUserLastClock($user, $projectModel)) {
                    //开始记录轨迹
                    $clock_data = new InspectClockData();
                    $clock_data->start_clock_id = $model->id;
                    $clock_data->project_id = $projectModel->id;
                    $clock_data->project_type = get_class($projectModel);
                    $clock_data->user_id = $user->id;
                    $clock_data->macid = $user->macid;
                    $clock_data->status = 0;

                } else {
                    //结束记录轨迹
                    $clock_data->status = 1;
                    $clock_data->end_clock_id = $model->id;
                };
                $clock_data->save();
                if ($clock_data->status == 0) {
                    $this->saveCheck($user, $clock_data, 1);
                }
                return $clock_data;
            });

            return $clock_data;
//        } catch (\Exception $exception) {
//            $this->throwBusinessException([$exception->getCode(), $exception->getMessage()]);
//        }

    }

    public function show(User $user)
    {
        $model = InspectClockData::query()->where("user_id", $user->id)->orderBy("id", 'desc')->first();
        $start_time = InspectClock::query()->where("id", $model->start_clock_id)->value('time');
        if (isset($start_time)) {
            $start_time = Carbon::parse($start_time)->format("H:i");
        }
        $end_time = InspectClock::query()->where("id", $model->end_clock_id)->value('time');
        if (isset($start_time)) {
            $start_time = Carbon::parse($end_time)->format("H:i");

        }
        return ['start' => $start_time, 'end' => $end_time];
    }

    public function project_list(string $type)
    {
        $project = ProjectFactory::CreateProject($type);
        if (!$project instanceof ProjectInterface) {//单纯只是为了下面代码有指引
            $this->throwBusinessException();
        }
        return $project->paginate();
    }

    /**
     * Notes:小程序推送定位
     * User: qianjinxiao
     * Date: 2022/8/9
     * Time: 10:15
     */
    public function pushAdd($data, $client_id)
    {
        try {
            $model = InspectClockData::query()->find($data['inspect_data_id']);
            if ($model->status == 0) {
                InspectLog::query()->create([
                    'inspect_data_id' => $data['inspect_data_id'],
                    'lat' => $data['lat'],
                    'lon' => $data['lon'],
                    'client_id' => $client_id
                ]);
            }
            return $this->success();
        } catch (\Exception $exception) {
            return $this->fail();
        }
    }

    //第一次打卡生成巡查表
    public function saveCheck($user, $inspect_data, $type = 1)
    {
        $check = Check::query()->create([
            'inspect_data_id' => $inspect_data->id,
            'date' => Carbon::now(),
            'user_name' => $user->name,
            'user_id' => $user->id,
        ]);
        Line::query()->where("project_id", $inspect_data->project_id)->where("project_type", $inspect_data->project_type)->where("type", $type)->select('id','region_id')->orderBy('order')->get()->each(function ($item) use ($check) {
            CheckNode::query()->create([
                'check_id' => $check->id,
                'line_id' => $item->id,
                'region_id' => $item->region_id,
            ]);
        });

    }
}
