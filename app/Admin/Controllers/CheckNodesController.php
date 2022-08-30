<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\ImportFarmlandInfos;
use App\Models\Check;
use App\Models\CheckNode;
use App\Models\Farmland\FarmlandInfo;
use Carbon\Carbon;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;

class CheckNodesController extends AdminController
{
    protected $title = '巡查表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $request = \request()->all();
        return Grid::make(CheckNode::with(['line', 'region', 'nodes']), function (Grid $grid) use ($request) {
            $grid->model()->wherehas('nodes', function ($q) use ($request) {
                $q->where('inspect_data_id', $request['id']);
            });
            $grid->header(function ($collection) use ($request) {
                $check = Check::query()->where('inspect_data_id', $request['id'])->first();
                $date = Carbon::parse($check->date)->format("Y-m-d H:i");

                return "<ul style='margin: 50px 0;'>
                <li style='border: 1px solid #000'><div style='float:left;width:100px;font-weight: bold'>日期:</div><div style='float:left;'>$date</div><div style='clear:both'></div></li>
                <li style='border: 1px solid #000'><div style='float:left;width:100px;font-weight: bold'>天气:</div><div style='float:left;'>$check->weather</div><div style='clear:both'></div></li>
                <li style='border: 1px solid #000'><div style='float:left;width:100px;font-weight: bold'>水位:</div><div style='float:left;'>$check->water</div><div style='clear:both'></div></li>
                <li style='border: 1px solid #000'><div style='float:left;width:100px;font-weight: bold'>巡查员:</div><div style='float:left;'>$check->user_name</div><div style='clear:both'></div></li>
                <li style='border: 1px solid #000'><div style='float:left;width:100px;font-weight: bold'>责任人:</div><div style='float:left;'>$check->duty_name</div><div style='clear:both'></div></li>
                <li style='border: 1px solid #000'><div style='float:left;width:100px;font-weight: bold'>巡查结论:</div><div style=float:left;> $check->content</div><div style='clear:both'></div></li>
</ul>";
            });
            $grid->export();
            $grid->column('id');
            $grid->column('region.name', '区域');
            $grid->column('line.name', '部位');
            $grid->column('is_check', '是否检查')->bool([1 => true, 0 => false]);
            $grid->column('is_problem', '是否有问题')->bool([1 => true, 0 => false]);
            $grid->column('desc', '问题描述');
            $grid->column('images', '图片')->image('', 200, 200);
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->disableViewButton();
            $grid->disableCreateButton();
            $grid->disableRowSelector();
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new CheckNode(), function (Form $form) {
            $form->display('id');
            $form->switch('is_check', '是否检查')->customFormat(function ($v) {
                return $v == 1 ? 1 : 0;
            })
                ->saving(function ($v) {
                    return $v;
                });;
            $form->switch('is_problem', '是否有问题')->customFormat(function ($v) {
                return $v == 1 ? 1 : 0;
            })
                ->saving(function ($v) {
                    return $v;
                });;
            $form->textarea('desc', '问题描述');
            $form->image('images', '图片')->saveFullUrl()->autoSave()->autoUpload();

        });
    }
}
