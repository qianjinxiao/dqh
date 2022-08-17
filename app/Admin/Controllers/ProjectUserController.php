<?php

namespace App\Admin\Controllers;

use App\Models\ProjectUser;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ProjectUserController extends BaseAdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid($id,$class)
    {
        return Grid::make(ProjectUser::with('user')->where(['project_id'=>$id,'project_type'=>$class]), function (Grid $grid) use ($id,$class) {
            $grid->column('id')->sortable();
            $grid->column('job', '人员岗位');
            $grid->column('user.name', '姓名');
            $grid->column('user.edu', '学历');
            $grid->column('user.professional', '专业');
            $grid->column('user.job_title', '职称');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableViewButton();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->setResource('project_user');
            $grid->model()->setConstraints([
                'id' => $id,
                'class' => $class,
            ]);
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ProjectUser(), function (Form $form) {
            $form->display('id');
            $form->select('user_id','用户')->options(User::query()->pluck("name",'id'));
            $form->hidden('project_id')->value(\request()->input("id"));
            $form->hidden('project_type')->value(\request()->input("class"));
            $form->text('job','岗位');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
