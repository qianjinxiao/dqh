<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\UserImei;
use App\Services\UserImeiService;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Hash;

class UserImeiController extends BaseAdminController
{
    public $title='设备绑定';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new UserImei(), function (Grid $grid) {
            if(request()->exists('user_id')){
                $grid->model()->where('user_id',request('user_id'));
            }
            $grid->column('id')->sortable();
            $grid->column('name','名字');
            $grid->column('macid','设备号');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->disableViewButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->equal('user_id');
            });
            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
        });
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make( UserImei::with(['user']), function (Form $form) {
            $form->display('id');
            $form->select('user_id','选择员工')->options(User::query()->pluck('name','id'));
            $form->text('name','姓名');
            $form->text('macid','设备号');

            $form->display('created_at');
            $form->display('updated_at');

        });
    }
}
