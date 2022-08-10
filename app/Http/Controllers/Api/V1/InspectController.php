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
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\User;
use App\Services\InspectStatisticalService;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class InspectController extends BaseController
{
    public function clock(InspectClockRequest $request){
        $user=$request->user();
        $data=$request->only('lat','lon','address','macid');
        $model=InspectStatisticalService::getInstance()->clock($user,$request->input('project_type'),$request->project_id,$data);
        return $this->success($model);
    }
    public function project_enum(Request $request){
        return $this->success(ProjectEnum::$project_list);
    }
    public function project_list(string $type,Request $request){
        $list=InspectStatisticalService::getInstance()->project_list($type);
        return $this->successPaginate($list);
    }
}
