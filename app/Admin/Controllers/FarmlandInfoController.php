<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\ImportFarmlandInfos;
use App\Models\Farmland\FarmlandInfo;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class FarmlandInfoController extends AdminController
{
    protected $title='基本信息';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new FarmlandInfo(), function (Grid $grid) {
            $grid->model()->orderBy('id','desc');
            $grid->column('id')->sortable();
            $grid->column('villagers','村名');
            $grid->column('name','项目名称(及批准文件)');
            $grid->column('address','地块位置(小地名)');
            $grid->column('type','使用类型');
            $grid->column('mj1','政策处理土地协议面积');
            $grid->column('mj2','转正式征用面积');
            $grid->column('mj3','剩余土地面积');
            $grid->column('mj4','剩余土地占用面积');
            $grid->column('mj5','剩余实际可用面积');
            $grid->column('quo','剩余土地现状');
            $grid->column('desc','备注');

            $grid->tools(function (Grid\Tools $tools) {
                //Excel导入
                $tools->append(new  ImportFarmlandInfos());
            });
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableRowSelector();
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
        return Show::make($id, new FarmlandInfo(), function (Show $show) {
            $show->field('id');
            $show->field('villagers');
            $show->field('name');
            $show->field('address');
            $show->field('type');
            $show->field('mj1');
            $show->field('mj2');
            $show->field('mj3');
            $show->field('mj4');
            $show->field('mj5');
            $show->field('quo');
            $show->field('desc');
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
        return Form::make(new FarmlandInfo(), function (Form $form) {
            $form->display('id');
            $form->text('villagers');
            $form->text('name');
            $form->text('address');
            $form->text('type');
            $form->text('mj1');
            $form->text('mj2');
            $form->text('mj3');
            $form->text('mj4');
            $form->text('mj5');
            $form->text('quo');
            $form->text('desc');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
