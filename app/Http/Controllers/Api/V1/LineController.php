<?php

namespace App\Http\Controllers\Api\V1;

use App\Factory\ProjectFactory;
use App\Http\Controllers\Api\BaseController;
use App\Models\Check;
use App\Models\CheckNode;
use App\Models\Inspect\InspectClockData;
use App\Models\Line;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LineController extends BaseController
{
    public function list(Request $request, Region $region)
    {
        $type = $request->input('type', 1);
        $InspectClockData = InspectClockData::query()->find($request->inspect_data_id);
        $check=Check::query()->where('inspect_data_id',$InspectClockData->id)->first();
        $list = $region->with(['check_nodes'=>function($q)use($check){
            return $q->where('check_id',$check->id)->select('id','region_id','line_id','is_check');
        },'check_nodes.line'=>function($q){
            $q->select('id','name');
        }])->select('id','name')->where("project_id", $InspectClockData->project_id)->where("project_type", $InspectClockData->project_type)->where("type", $type)->orderBy('order')->get();

        return $this->success(['check'=>$check,'nodes'=>$list]);
    }
    public function update(Check $check,Request $request){
        if(isset($request->date)){
            $check->date=Carbon::parse($request->date);
        }
        if(isset($request->weather)){
            $check->weather=$request->weather;
        }
        if(isset($request->water)){
            $check->water=$request->water;
        }
        if(isset($request->user_name)){
            $check->user_name=$request->user_name;
        }
        if(isset($request->duty_name)){
            $check->duty_name=$request->duty_name;
        }
        if($request->exists("content")){
            $check->content=$request->input("content");
        }
        $check->save();
        return $this->success($check);
    }
    public function node_show(CheckNode $checkNode){
        $checkNode->line_name=Line::query()->where("id",$checkNode->line_id)->value("name");
        $checkNode->region_name=Region::query()->where("id",$checkNode->region_id)->value("name");
        return $this->success($checkNode);
    }
    public function node_update(CheckNode $checkNode,Request $request){
        if(isset($request->is_check)){
            $checkNode->is_check=$request->is_check;
        }
        if(isset($request->is_problem)){
            $checkNode->is_problem=$request->is_problem;
        }
        if(isset($request->is_push)){
            $checkNode->is_push=$request->is_push;
        }
        if(isset($request->desc)){
            $checkNode->desc=$request->desc;
        }
        if(isset($request->images) && is_array($request->images)){
            $checkNode->images=$request->images;
        }
        if(isset($request->videos)  && is_array($request->videos)){
            $checkNode->videos=$request->videos;
        }
        $checkNode->save();
        return $this->success($checkNode);
    }
}
