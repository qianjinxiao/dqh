<?php

namespace App\Admin\Controllers;

use App\Models\EmergencySupply;
use App\Models\ProjectInterface;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Table;

class EmergencySupplyController extends BaseAdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    public function grid(ProjectInterface $item)
    {
        return Grid::make(EmergencySupply::with([])->byProject($item)->orderBy("id", 'desc'), function (Grid $grid)use ($item) {
            $grid->column('name','储备点');
            $grid->column('type','类别')->using(EmergencySupply::$typeMap);
            $grid->column('show','查看')->modal(function($model){
                $html="
                    <p><span>物资类别:</span><span>".EmergencySupply::$typeMap[$this->type]."</span></p>
                    <p><span>储备点:</span><span>".$this->name."</span></p>
                    <p><span>仓库面积(平方米):</span><span>".$this->warehouse."</span></p>
                    <p><span>草袋(万条):</span><span>".$this->straw_bag."</span></p>
                    <p><span>麻袋(万条):</span><span>".$this->sacks."</span></p>
                    <p><span>编织袋(万条):</span><span>".$this->woven_bag."</span></p>
                    <p><span>膨胀袋(万条):</span><span>".$this->Inflation_bag."</span></p>
                ";
               return Card::make($html);

            });
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->disableRowSelector();
            $grid->showQuickEditButton();
            $grid->setResource('emergency_supply');
            $grid->model()->setConstraints([
                'id' => $item->id,
                'type' => get_class($item),
            ]);
        });
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new EmergencySupply(), function (Form $form) {
            $form->display('id');
            $form->text('name','储备点');
            $form->select('type','类别')->options(EmergencySupply::$typeMap);
            if($form->isEditing()){
                $form->text('warehouse','仓库面积(平方米)');
                $form->text('straw_bag','草袋(万条)');
                $form->text('sacks','麻袋(万条)');
                $form->text('woven_bag','编织袋(万条)');
                $form->text('Inflation_bag','膨胀袋(万条)');
            }

            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("type"));
            $form->hidden("admin_id")->value(\Admin::user()->id);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
