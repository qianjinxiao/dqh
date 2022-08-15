<?php

namespace App\Admin\Controllers;

use App\Models\ProjectInterface;
use App\Models\WaterPlan;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;

class WaterPlanController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid(ProjectInterface $item)
    {
        $wp=WaterPlan::with([])->byProject($item)->orderBy("id", 'desc')->first();
        if($wp){
            $list=WaterPlan::with([])->find($wp->id);
        }else{
            $list=WaterPlan::with([])->byProject($item)->orderBy("id", 'desc');
        }
        return Grid::make( $list, function (Grid $grid)use ($item) {
            $grid->column('file','预览')->view("pdf")->width(1200);
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->disableRowSelector();
            $grid->showQuickEditButton();
            $grid->setResource('water_plan');
            $grid->model()->setConstraints([
                'id' => $item->id,
                'type' => get_class($item),
            ]);
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new WaterPlan(), function (Show $show) {
            $show->field('id');
            $show->field('admin_id');
            $show->field('file');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WaterPlan(), function (Form $form) {
            $form->display('id');
            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("type"));
            $form->hidden("admin_id")->value(\Admin::user()->id);
            $form->file("file", '附件')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
