<?php

namespace App\Admin\Controllers;

use App\Enum\ProjectEnum;
use App\Factory\ProjectFactory;
use App\Models\Imei;
use App\Models\User;
use App\Services\UserImeiService;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    public $title = '员工';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name', '姓名');
            $grid->column('avatar', '头像')->image();
            $grid->column('edu', '学历');
            $grid->column('professional', '专业');
            $grid->column('job_title', '职称');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableViewButton();
            $grid->actions(function ($action) {
                $user_id = $this->id;
                $action->append("<a href='/admin/employees_imei?user_id=$user_id'>设备管理</a>");
            });
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name');
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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('password');
            $show->field('remember_token');
            $show->field('edu');
            $show->field('professional');
            $show->field('job_title');
            $show->field('username');
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
        return Form::make(User::with([])->with("project"), function (Form $form) {
            $form->display('id');
            $form->text('name', '姓名');
            $form->image('avatar', '头像')->saveFullUrl()->autoUpload()->autoSave()->uniqueName();
            $form->text('edu', '学历');
            $form->text('professional', '专业');
            $form->text('job_title', '职称');
            $form->hidden('fishing_name', '渔船名字');
            $form->hidden('macid', '设备id');
            $form->select('imei_id', '选择设备绑定')->options(Imei::query()->pluck('name', 'id'));
            $form->text('username');
            $form->password('password');
            $form->select("project.project_type", "选择类型")->load('project.project_id', '/api/get_project_id')->options(ProjectEnum::$allTypeMap)->help("用于绑定默认打卡地址");
            $form->select("project.project_id", "选择区域");
            $form->hidden("project.job");
            $form->display('created_at');
            $form->display('updated_at');
            $form->saving(function (Form $form) {
                $imei = Imei::query()->find($form->imei_id);
                $form->input('fishing_name', $imei->name);
                $form->input('macid', $imei->macid);
                $form->input('project.job', $form->job_title);
                $form->password = Hash::make($form->password);
            });

        });
    }

    public function get_project_id(Request $request)
    {
        $type = $request->get('q');
        return ProjectFactory::CreateProjectForClass($type)->get(['id', DB::raw('name as text')]);
    }
}
