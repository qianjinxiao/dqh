<?php

namespace App\Admin\Controllers;

use App\Models\Rectification;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class RectificationController extends AdminController
{
    public $title='整改情况';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make( new Rectification(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('date');
            $grid->column('address');
            $grid->column('content');
            $grid->column('status')->using([0=>'未整改',1=>'已整改']);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new Rectification(), function (Show $show) {
            $show->field('id');
            $show->field('date');
            $show->field('address');
            $show->field('content');
            $show->field('status');
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
        return Form::make(new Rectification(), function (Form $form) {
            $form->display('id');
            $form->date('date');
            $form->text('address');
            $form->textarea('content');
            $form->radio('status')->options([0=>'未整改',1=>'已整改'])->default(0);
            $form->hidden('admin_id')->default(\Admin::user()->id);

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
