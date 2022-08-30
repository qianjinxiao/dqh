<?php

namespace App\Admin\Renderable;

use App\Models\CheckNode;
use Carbon\Carbon;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectTable extends LazyRenderable
{
    public function grid(): Grid
    {
        $request=\request()->all();
        return Grid::make(CheckNode::with(['line','region'])->join('checks as check','check.id','=','check_nodes.check_id'),function (Grid $grid)use ($request){
            $grid->model()->where('check.inspect_data_id',$request['id']);
            $grid->column('region.name','区域');
            $grid->column('line.name','部位');
            $grid->column('is_check','是否检查')->editable();
            $grid->column('is_problem','是否有问题');
            $grid->column('desc','问题描述');
            $grid->column('images','图片')->image('',200,200);
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->disableViewButton();
            $grid->disableCreateButton();
            $grid->disableRowSelector();
        });
    }
}
