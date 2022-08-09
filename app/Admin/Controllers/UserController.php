<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Services\UserImeiService;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    public $title='员工';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name','姓名');
            $grid->column('edu','学历');
            $grid->column('professional','专业');
            $grid->column('job_title','职称');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableViewButton();
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
        return Form::make( User::with("imei"), function (Form $form) {
            $form->display('id');
            $form->text('name','姓名');
            $form->text('edu','学历');
            $form->text('professional','专业');
            $form->text('job_title','职称');
            $form->text('fishing_name','渔船名字');
            $form->text('macid','设备id');
            $form->text('username');
            $form->password('password');

            $form->display('created_at');
            $form->display('updated_at');
            $form->saving(function (Form $form){
                $form->password=Hash::make($form->password);
            });
            $form->saved(function (Form $form){
               if($form->input('macid')!=""){
                    $res=UserImeiService::getInstance()->Reg(User::find($form->getKey()),$form->input('macid'),$form->input('fishing_name'));
               }
            });
        });
    }
}
