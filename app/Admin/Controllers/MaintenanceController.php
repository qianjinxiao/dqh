<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\MaintenancePush;
use App\Admin\Actions\Traits\TabBase;
use App\Admin\Interfaces\TabInterface;
use App\Enum\ProjectEnum;
use App\Models\Maintenance;
use App\Models\ProjectInterface;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;

class MaintenanceController extends BaseAdminController implements TabInterface
{
    use TabBase;


    const  TYPE1 = "type1";
    const  TYPE2 = "type2";
    const  TYPE3 = "type3";
    protected static $tabMap = [
        self::TYPE1 => "维修养护经费",
        self::TYPE2 => "维修养护项目",
        self::TYPE3 => "隐患处理",
    ];

    public function custom_tab(ProjectInterface $item, string $type)
    {
        switch ($type) {
            case self::TYPE1:
                return $this->grid($item);
            case self::TYPE2:
                return (new MaintenanceProjectController())->grid($item);
            case self::TYPE3:
                return (new MaintenanceTroubleController())->grid($item);
        }
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(ProjectInterface $item)
    {
        return Grid::make( Maintenance::with([])->byProject($item)->orderBy("id", 'desc'), function (Grid $grid)use ($item) {
            $grid->column('id')->sortable();
            $grid->column('year');
            $grid->column('declaration_money');
            $grid->column('top_money');
            $grid->column('self_raised_money');
            $grid->column('actual_completed_money');
            $grid->column('payed_money');
            $grid->column('declaration_file1','申报文件')->modal(function ($modal){
                $card=Card::make('',view('pdf',['value'=>$this->declaration_file]));
                return $card;
            });
            $grid->column('plan_file1','计划文件')->modal(function ($modal){
                $card=Card::make('',view('pdf',['value'=>$this->plan_file]));
                return $card;
            });
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
            $grid->disableViewButton();
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->model()->setConstraints([
                'id' => $item->id,
                'type' => get_class($item),
            ]);
            $grid->actions(function ( $action){
                if($this->is_push==0){
                    $action->append(new MaintenancePush());
                }else{
                    $action->append("<button class='btn btn-outline-success btn-xs'>已上报</button>");
                }
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
        return Show::make($id, new Maintenance(), function (Show $show) {
            $show->field('id');
            $show->field('year');
            $show->field('declaration_money');
            $show->field('top_money');
            $show->field('self_raised_money');
            $show->field('actual_completed_money');
            $show->field('payed_money');
            $show->field('declaration_file');
            $show->field('plan_file');
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
        return Form::make(new Maintenance(), function (Form $form) {
            $form->display('id');
            $form->year('year')->required();
            $form->text('declaration_money')->required();
            $form->text('top_money')->required();
            $form->text('self_raised_money')->required();
            $form->text('actual_completed_money')->required();
            $form->text('payed_money')->required();
            $form->file('declaration_file')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();;
            $form->file('plan_file')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();;
            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("type"));
            $form->hidden("admin_id")->value(\Admin::user()->id);
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

}
