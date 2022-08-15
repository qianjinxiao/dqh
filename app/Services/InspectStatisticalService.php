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
use App\Models\Inspect\InspectClock;
use App\Models\Inspect\InspectClockData;
use App\Models\Inspect\InspectLog;
use App\Models\Inspect\InspectStatistical;
use App\Models\ProjectInterface;
use App\Models\User;
use App\Models\UserImei;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Static_;

class InspectStatisticalService extends BaseService
{
    //使用gps的类型
    protected static $gps_type=[
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
        try {
            //查询对象
            $projectModel = $project->where('id', $id)->first();
            if(!in_array($type,self::$gps_type)){
                $lat=$data['lat'];
                $lon=$data['lon'];
                $address=$data['address'];
            }else{
                $device_info=UserImeiService::getInstance()->location($user,UserImei::getDefault($user)->macid);
                $lat=$device_info['lat'];
                $lon=$device_info['lon'];
                $address=UserImeiService::getInstance()->decode_address($lat,$lon);
            }
            $model = InspectClock::create([
                'user_id' => $user->id,
                'project_id' => $projectModel->id,
                'project_type' => get_class($projectModel),
                'address' => $address,
                'lat' => $lat,
                'lon' => $lon,
                'device_info'=>json_encode($device_info??[]),
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
                $clock_data->macid = $data['macid'] ?? 0;
            } else {
                //结束记录轨迹
                $clock_data->status = 1;
                $clock_data->end_clock_id = $model->id;
            };
            $clock_data->save();
            return $clock_data;
        } catch (\Exception $exception) {
            $this->throwBusinessException([$exception->getCode(),$exception->getMessage()]);
        }

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
    public function pushAdd($data)
    {
        try {
            InspectLog::query()->create([
                'inspect_data_id' => $data['inspect_data_id'],
                'lat' => $data['lat'],
                'lon' => $data['lon'],
            ]);
            return $this->success();
        } catch (\Exception $exception) {
           return $this->fail();
        }
    }
}