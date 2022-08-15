<?php

namespace App\Admin\Controllers;

use App\Models\MaintenanceTrouble;
use App\Models\ProjectInterface;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MaintenanceTroubleController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid(ProjectInterface $item)
    {
        return Grid::make( MaintenanceTrouble::with([])->byProject($item)->orderBy("id", 'desc'), function (Grid $grid)use ($item) {
            $grid->column('id')->sortable();
            $grid->column('process_state','处理流程状态')->using(MaintenanceTrouble::$processStateMap);
            $grid->column('code','编号');
            $grid->column('name','名称');
            $grid->column('address','所在区域');
            $grid->column('defect_content','缺陷内容');
            $grid->column('found_at','发现时间');
            $grid->column('found_people','发现人');
            $grid->column('rid_people','消缺人');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('设备名称');
            });
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->disableRowSelector();
            $grid->showQuickEditButton();
            $grid->setResource('maintenance_trouble');
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
        return Show::make($id, new MaintenanceTrouble(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('address');
            $show->field('code');
            $show->field('found_type');
            $show->field('found_at');
            $show->field('found_people');
            $show->field('defect_content');
            $show->field('image');
            $show->field('plan_completed_at');
            $show->field('rid_people');
            $show->field('rid_phone');
            $show->field('process_mode');
            $show->field('status');
            $show->field('completed_at');
            $show->field('complete_image');
            $show->field('opinion');
            $show->field('note');
            $show->field('recipient');
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
        return Form::make(new MaintenanceTrouble(), function (Form $form) {
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('设备信息');
                $form->row(function (Form\Row $form) {
                    $form->hidden('id');
                    $form->width(6)->text('name','设备名称');
                    $form->width(6)->text('address','所在地点');
                });
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('缺陷问题分析');
                $form->row(function (Form\Row $form) {
                    $form->width(6)->text('code','编码');
                    $form->width(6)->select('found_type','日常巡查')->options(MaintenanceTrouble::$foundTypeMap);
                });
                $form->row(function (Form\Row $form) {
                    $form->width(6)->datetime('found_at','发现时间');
                    $form->width(6)->text('found_people','发现人');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->textarea('defect_content','缺陷内容');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->image('image','照片')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();
                });
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('缺陷处理申请');
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('维修申请审批');
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('维修结果记录');
            });
            $form->block(8, function (Form\BlockForm $form) {
                $form->title('结果审核');
            });
//            $form->text('name');
//            $form->text('address');
//            $form->text('code');
//            $form->text('found_type');
//            $form->text('found_at');
//            $form->text('found_people');
//            $form->text('defect_content');
//            $form->text('image');
//            $form->text('plan_completed_at');
//            $form->text('rid_people');
//            $form->text('rid_phone');
//            $form->text('process_mode');
//            $form->text('status');
//            $form->text('completed_at');
//            $form->text('complete_image');
//            $form->text('opinion');
//            $form->text('note');
//            $form->text('recipient');
//
//            $form->display('created_at');
//            $form->display('updated_at');
        });
    }
}
