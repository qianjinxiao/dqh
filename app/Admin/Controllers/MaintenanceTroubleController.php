<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\MaintenanceProjectPush;
use App\Admin\Actions\Grid\MaintenanceTroublePushResult;
use App\Admin\Actions\Grid\MaintenanceTroublePushYh;
use App\Models\MaintenanceTrouble;
use App\Models\ProjectInterface;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class MaintenanceTroubleController extends BaseAdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid(ProjectInterface $item)
    {
        return Grid::make(MaintenanceTrouble::with([])->byProject($item)->orderBy("id", 'desc'), function (Grid $grid) use ($item) {
            if(request()->exists("found_at".$item->id)){
                request()->offsetSet("found_at",request("found_at".$item->id));
                request()->offsetSet("found_at".$item->id,null);
                $grid->model()->whereBetween("found_at",request("found_at"));
            }
            $grid->column('id')->sortable();
            $grid->column('process_state', '处理流程状态')->using(MaintenanceTrouble::$processStateMap);
            $grid->column('code', '编号');
            $grid->column('name', '名称');
            $grid->column('address', '所在区域');
            $grid->column('defect_content', '缺陷内容');
            $grid->column('found_at', '发现时间');
            $grid->column('found_people', '发现人');
            $grid->column('rid_people', '消缺人');
            $grid->filter(function (Grid\Filter $filter) use ($item){
                $filter->equal('id');
                $filter->like('设备名称');
                $filter->between('found_at'.$item->id,'实际完成时间')->datetime()->setValue(request('found_at'));
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
            $grid->actions(function ($action){
                if($this->is_push_yh==0){
                    $action->append(new MaintenanceTroublePushYh());
                }else{
                    $action->append("<button class='btn btn-outline-success btn-xs'>已上报隐患</button>&nbsp;&nbsp;");
                }
                if($this->is_push_result==0){
                    $action->append(new MaintenanceTroublePushResult());
                }else{
                    $action->append("<button class='btn btn-outline-success btn-xs'>已上报处理结果</button>&nbsp;&nbsp;");
                }
            });
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
                    $form->width(6)->text('name', '设备名称');
                    $form->width(6)->text('address', '所在地点');
                });
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('缺陷问题分析');
                $form->row(function (Form\Row $form) {
                    $form->width(6)->text('code', '编码');
                    $form->width(6)->select('found_type', '日常巡查')->options(MaintenanceTrouble::$foundTypeMap);
                });
                $form->row(function (Form\Row $form) {
                    $form->width(6)->datetime('found_at', '发现时间');
                    $form->width(6)->text('found_people', '发现人');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->textarea('defect_content', '缺陷内容');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->image('image', '照片')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();
                });
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('缺陷处理申请');
                $form->row(function (Form\Row $form) {
                    $form->width(6)->datetime('plan_completed_at', '计划治理完成时间');
                    $form->width(6)->text('rid_people', '消缺人');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->text('rid_phone', '消缺人电话');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->select('process_mode', '处理方式')->options(MaintenanceTrouble::$processMoodMap);
                });
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('维修申请审批');
                $form->row(function (Form\Row $form) {
                    $form->width(12)->select('status', '审批操作')->options(MaintenanceTrouble::$statusMap);
                });
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('维修结果记录');
                $form->row(function (Form\Row $form) {
                    $form->width(12)->datetime('completed_at', '实际完成时间');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->image('complete_image', '照片');
                });
            });
            $form->block(12, function (Form\BlockForm $form) {
                $form->title('结果审核');
                $form->row(function (Form\Row $form) {
                    $form->width(12)->textarea('opinion', '意见');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->textarea('note', '短信内容');
                });
                $form->row(function (Form\Row $form) {
                    $form->width(6)->text('recipient', '手机号');
                    $form->width(6)->radio('is_send', '是否发送')->options([0=>'否',1=>'是']);
                });
                $form->row(function (Form\Row $form) {
                    $form->width(12)->hidden('process_state')->default(1);
                    $form->hidden("project_id")->value(request()->get("id"));
                    $form->hidden("project_type")->value(request()->get("type"));
                    $form->hidden("admin_id")->value(\Admin::user()->id);
                });
            });
            $form->saving(function ($form){
                $form->process_state=1;
                    if($form->status>0){
                        $form->process_state=2;
                    }
                    if($form->completed_at!=null){
                        $form->process_state=3;
                    }
                if($form->opinion!=null){
                    $form->process_state=4;
                }
            });
        });
    }
}
