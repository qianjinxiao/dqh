<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Traits\TabBase;
use App\Admin\Interfaces\TabInterface;
use App\Enum\ProjectEnum;
use App\Models\EmergencyPlan;
use App\Models\ProjectInterface;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class EmergencyPlanController extends BaseAdminController implements TabInterface
{
    use TabBase;
    const  PLAN = "plan";
    const  SUPPLIES = "supplies";
    const  PUSH = "push";
    protected static $tabMap = [
        self::PLAN => "应急预案",
        self::SUPPLIES => "防讯物资",
        self::PUSH => "险情上报",
    ];
    public function custom_tab(ProjectInterface $item, string $type)
    {
        switch ($type) {
            case self::PLAN:
                return $this->grid($item);
            case self::PUSH:
                return (new EmergencyReportController())->grid($item);
            case self::SUPPLIES:
                return (new EmergencySupplyController())->grid($item);
        }
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(ProjectInterface $item)
    {

        return Grid::make(EmergencyPlan::byProject($item)->orderBy("id", 'desc'), function (Grid $grid)use ($item) {
            if(request()->exists("compiled_at".$item->id)){
                request()->offsetSet("compiled_at",request("compiled_at".$item->id));
                request()->offsetSet("compiled_at".$item->id,null);
                $grid->model()->whereBetween("compiled_at",request("compiled_at"));
            }
            $grid->column('id')->sortable();
            $grid->column('name','文件名称');
            $grid->column('unit','编制单位');
            $grid->column('address','地址');
            $grid->column('compiled_at','编制时间');
            $grid->column('file','附件')->view("pdf");
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            $grid->filter(function (Grid\Filter $filter)use ($item) {
                $filter->panel();
                $filter->expand();
                $filter->equal('id');
                $filter->like('name','文件名称');
                $filter->between('compiled_at'.$item->id,'编制时间')->datetime()->setValue(request('compiled_at'));

            });
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->model()->setConstraints([
                'id' => $item->id,
                'type' => get_class($item),
            ]);
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
        return Show::make($id, new EmergencyPlan(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('unit');
            $show->field('address');
            $show->field('compiled_at');
            $show->field('file');
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
        return Form::make(new EmergencyPlan(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('unit');
            $form->text('address');
            $form->datetime('compiled_at');
            $form->file("file", '附件')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();
            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("type"));
            $form->display('created_at');
            $form->display('updated_at');
        });
    }


}
