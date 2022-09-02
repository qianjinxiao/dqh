<?php

namespace App\Admin\Controllers;

use App\Models\Imei;
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
        return Grid::make(new Imei(), function (Grid $grid) {
            $grid->column('name','名字');
            $grid->column('macid','设备号');
            $grid->column('mds','密钥');
            $grid->showQuickEditButton();
            $grid->disableEditButton();
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
        return Form::make( Imei::with([]), function (Form $form) {
            $form->display('id');
            $form->text('name','渔船');
            $form->text('macid','设备号');

        });
    }
}
