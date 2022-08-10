<?php

namespace App\Admin\Renderable;

use App\Models\Inspect\InspectLog;
use App\Models\User;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Admin;
use Dcat\Admin\Support\LazyRenderable;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Trajectory extends LazyRenderable
{


    public function render()
    {
        $id=$this->payload['id'];
        $type=$this->payload['type'];
        if($type=="GPS"){
            $macid=$this->payload['macid'];
            $user=User::query()->find($this->user_id);
            $a=\App\Services\UserImeiService::getInstance()->routerPass($macid,$user->mds);
            return view("trajectory_url",['url'=>$a]);
        }else{
            $adds=InspectLog::query()->where("inspect_data_id",$id)->get(DB::raw("lat,lon"))->toArray();
            foreach ($adds as &$v){
                $v=array_values($v);
            }
            return view('trajectory',['id'=>$id,'adds'=>urlencode(json_encode($adds))]);
        }

    }
}
