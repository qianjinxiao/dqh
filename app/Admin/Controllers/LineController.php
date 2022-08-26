<?php

namespace App\Admin\Controllers;

use App\Models\Line;
use App\Models\Region;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class LineController extends AdminController
{
    public $title='线路设置';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    Public function grid($class,$id,$type)
    {
        return Grid::make( new Line(), function (Grid $grid) use ($class,$id,$type){
            $grid->setName("line");

            $grid->model()->with('region')->where("project_id", $id)->where("project_type",$class)->where("type",$type)->orderBy('order');
            $grid->column('id')->sortable();
            $grid->column('region.name','区域名字');
            $grid->column('name','部位');
            $grid->order->orderable();
            $grid->disableViewButton();
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->disableRowSelector();
            $grid->showQuickEditButton();
            $grid->setResource('line');
            $grid->model()->setConstraints([
                'id' => $id,
                'class' => $class,
                'type' => $type,
            ]);
        });
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Line(), function (Form $form) {

            $form->display('id');
            $form->select('region_id','区域')->options(
                Region::query()->where([

                    'project_id'=>request('id'),
                    'project_type'=>request('class'),
                    'type'=>request('type'),
                ])->pluck('name','id')
            );
            $form->text('name','部位');
            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("class"));
            $form->hidden("admin_id")->value(\Admin::user()->id);
            $form->hidden("type")->value(request()->get("type"));
            $form->hidden("order");

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
