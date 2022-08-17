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
 * Date: 2022/8/17
 * Time: 14:42
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\ProblemRequest;
use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemController extends BaseController
{
    public function create(ProblemRequest $request,Problem $problem){
        $problem->project_name=$request->project_name;
        $problem->title=$request->title;
        $problem->user_name=$request->user_name;
        $problem->type=$request->type;
        $problem->desc=$request->desc;
        $problem->images=$request->images;
        $problem->user_id=$request->user()->id;
        $problem->save();
        return $this->success();
    }
    public function show(Problem $problem){
        return $this->success($problem);
    }
    public function list(Request $request){
        return $this->successPaginate(Problem::query()->where('user_id',$request->user()->id)->orderBy('id','desc')->paginate());
    }
}
