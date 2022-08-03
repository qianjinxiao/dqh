<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    public function tab_select(Request $request)
    {
        $q=$request->input("q");
         Cache::put("tab_select_".$request->input('class'),$q);
        return ["errcode"=>0,'data'=>[],'message'=>'成功'];
    }
}
