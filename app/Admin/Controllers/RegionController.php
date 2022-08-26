<?php

namespace App\Admin\Controllers;

use App\Models\Region;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;

class RegionController extends AdminController
{
    public $title='区域设置';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    Public function grid($class,$id,$type)
    {
        return Grid::make( new Region(), function (Grid $grid) use ($class,$id,$type){
            $grid->setName("region");
            $grid->setResource('region');
            $grid->model()->where("project_id", $id)->where("project_type",$class)->where("type",$type)->orderBy('order');
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->order->orderable();
            $grid->disableViewButton();
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->disableRowSelector();
            $grid->showQuickEditButton();
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
        return Form::make(new Region(), function (Form $form) {
            $form->display('id');
            $form->text('name','区域名字');
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
