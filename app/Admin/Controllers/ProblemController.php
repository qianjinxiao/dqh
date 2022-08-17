<?php

namespace App\Admin\Controllers;

use App\Models\Problem;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ProblemController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Problem(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('project_name');
            $grid->column('title');
            $grid->column('user_name');
            $grid->column('type');
            $grid->column('desc');
            $grid->column('images');
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
        return Show::make($id, new Problem(), function (Show $show) {
            $show->field('id');
            $show->field('project_name');
            $show->field('title');
            $show->field('user_name');
            $show->field('type');
            $show->field('desc');
            $show->field('images');
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
        return Form::make(new Problem(), function (Form $form) {
            $form->display('id');
            $form->text('project_name');
            $form->text('title');
            $form->text('user_name');
            $form->text('type');
            $form->text('desc');
            $form->text('images');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
