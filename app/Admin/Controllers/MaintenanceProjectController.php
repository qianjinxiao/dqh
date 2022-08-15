<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\MaintenanceProjectComplete;
use App\Admin\Actions\Grid\MaintenanceProjectPush;
use App\Admin\Actions\Grid\MaintenancePush;
use App\Models\MaintenanceProject;
use App\Models\ProjectInterface;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;

class MaintenanceProjectController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid(ProjectInterface $item)
    {
        return Grid::make( MaintenanceProject::with([])->byProject($item)->orderBy("id", 'desc'), function (Grid $grid)use ($item) {
            if(request()->exists("completed_at".$item->id)){
                request()->offsetSet("completed_at",request("completed_at".$item->id));
                request()->offsetSet("completed_at".$item->id,null);
                $grid->model()->whereBetween("completed_at",request("completed_at"));
            }
            $grid->column('id')->sortable();
            $grid->column('year','年份');
            $grid->column('year','年份');
            $grid->column('name','养护项目');
            $grid->column('type','类型')->using(MaintenanceProject::$typeMap);
            $grid->column('begin_at','计划开始时间');
            $grid->column('end_at','计划结束时间');
            $grid->column('before_image','维修前图片')->image('',200);
            $grid->column('after_image','维修后图片')->image('',200);
            $grid->column('completed_at','实际完成时间');
            $grid->column('file1','合同文件')->modal(function ($modal){
                $card=Card::make('',view('pdf',['value'=>$this->file]));
                return $card;
            });;
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter)use ($item) {
                $filter->equal('id');
                $filter->like('name');
                $filter->between('completed_at'.$item->id,'实际完成时间')->datetime();
            });
            $grid->actions(function ( $action){
                if($this->is_push==0){
                    $action->append(new MaintenanceProjectPush());
                }else{
                    $action->append("<button class='btn btn-outline-success btn-xs'>已上报</button>&nbsp;&nbsp;");
                }
                if($this->is_complete==0){
                    $action->append(new MaintenanceProjectComplete());
                }else{
                    $action->append("<button class='btn btn-outline-success btn-xs'>已完成</button>");
                }
            });
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->disableRowSelector();
            $grid->showQuickEditButton();
            $grid->setResource('maintenance_project');
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
        return Show::make($id, new MaintenanceProject(), function (Show $show) {
            $show->field('id');
            $show->field('year');
            $show->field('name');
            $show->field('type');
            $show->field('begin_at');
            $show->field('end_at');
            $show->field('before_image');
            $show->field('after_image');
            $show->field('completed_at');
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
        return Form::make(new MaintenanceProject(), function (Form $form) {
            $form->display('id')->required();
            $form->year('year')->required();
            $form->text('name')->required();
            $form->select('type','类型')->options(MaintenanceProject::$typeMap)->required();
            $form->datetime('begin_at')->required();
            $form->datetime('end_at')->required();
            $form->image('before_image')->required()->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();
            $form->datetime('completed_at')->required();
            $form->image('after_image')->required()->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();
            $form->file('file')->required()->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();
            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("type"));
            $form->hidden("admin_id")->value(\Admin::user()->id);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
