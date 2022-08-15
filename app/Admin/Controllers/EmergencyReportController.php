<?php

namespace App\Admin\Controllers;

use App\Models\EmergencyReport;
use App\Models\ProjectInterface;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class EmergencyReportController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid(ProjectInterface $item)
    {
        return Grid::make( EmergencyReport::with([])->byProject($item)->orderBy("id", 'desc'), function (Grid $grid)use ($item) {
            $grid->column('id')->sortable();
            $grid->column('report_person','上报人');
            $grid->column('phone','手机');
            $grid->column('address','险情位置');
            $grid->column('lat','险情位置经度');
            $grid->column('lon','险情位置纬度');
            $grid->column('desc','险情概况');
            $grid->column('is_dispose','是否处理');
            $grid->column('file','附件')->view("pdf")->width(500);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->disableRowSelector();
            $grid->showQuickEditButton();
            $grid->setResource('emergency_report');
            $grid->model()->setConstraints([
                'id' => $item->id,
                'type' => get_class($item),
            ]);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('report_person','上报人');
                $filter->like('phone','手机');

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
        return Show::make($id, new EmergencyReport(), function (Show $show) {
            $show->field('id');
            $show->field('report_person');
            $show->field('phone');
            $show->field('address');
            $show->field('lat');
            $show->field('lon');
            $show->field('desc');
            $show->field('is_dispose');
            $show->field('file');
            $show->field('admin_id');
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
        return Form::make(new EmergencyReport(), function (Form $form) {
            $form->display('id');
            $form->text('report_person');
            $form->text('phone');
            $form->text('address');
            $form->text('lat');
            $form->text('lon');
            $form->text('desc');
            $form->text('is_dispose');
            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("type"));
            $form->hidden("admin_id")->value(\Admin::user()->id);
            $form->file("file", '附件')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
