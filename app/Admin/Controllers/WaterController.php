<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Traits\TabBase;
use App\Admin\Interfaces\TabInterface;
use App\Enum\ProjectEnum;
use App\Models\ProjectInterface;
use App\Models\Water;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class WaterController extends BaseAdminController implements TabInterface
{
    use TabBase;


    const  WATER_LOG = "water_log";
    const  WATER_PLAN = "water_plan";
    protected static $tabMap = [
        self::WATER_LOG => "放水记录",
        self::WATER_PLAN => "放水预案",
    ];

    public function custom_tab(ProjectInterface $item, string $type)
    {
        switch ($type) {
            case self::WATER_LOG:
                return $this->grid($item);
            case self::WATER_PLAN:
                return (new WaterPlanController())->grid($item);
        }
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(ProjectInterface $item)
    {
        return Grid::make( Water::with([])->byProject($item)->orderBy("id", 'desc'), function (Grid $grid)use ($item) {
            $grid->column('id')->sortable();
            $grid->column('name','操作名称');
            $grid->column('begin_at','开始时间');
            $grid->column('end_at','结束时间');
            $grid->column('option','操作人');
            $grid->column('principal','负责人');
            $grid->column('desc','完成情况');
            $grid->column('file','附件')->image('',100,100);
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name');

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
        return Show::make($id, new Water(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('begin_at');
            $show->field('end_at');
            $show->field('admin_id');
            $show->field('option');
            $show->field('principal');
            $show->field('desc');
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
        return Form::make(new Water(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("type"));
            $form->hidden("admin_id")->value(\Admin::user()->id);
            if($form->isEditing()){
                $form->datetime('begin_at','开始时间');
                $form->datetime('end_at','结束时间');
                $form->text('option','操作/检查员');
                $form->text('principal','负责/监视人');
                $form->text('desc','完成情况');
                $form->file("file", '附件')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();
            }


            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
