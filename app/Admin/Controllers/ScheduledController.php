<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Traits\TabBase;
use App\Admin\Interfaces\TabInterface;
use App\Enum\ProjectEnum;
use App\Models\Inspect\InspectClockData;
use App\Models\ProjectInterface;
use App\Models\Scheduled;
use App\Models\SmallReservoirs\ProjectInfo;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Tab;

class ScheduledController extends BaseAdminController implements TabInterface
{
    use TabBase;


    const  PLAN = "plan";
    protected static $tabMap = [
        self::PLAN => "控运计划",
    ];

    public function custom_tab(ProjectInterface $item, string $type)
    {
        switch ($type) {
            case self::PLAN:
                return $this->grid($item);
        }
    }

    public function grid(ProjectInterface $item)
    {
        return Grid::make(Scheduled::with(['admin'])->byProject($item)->orderBy("id", 'desc'), function (Grid $grid) use ($item) {
            $grid->column('id', 'Id');
            $grid->column('name', '文件名称');
            $grid->column('year', '年度');
            $grid->column('type', '类型')->using(Scheduled::$typeMap);
            $grid->column('file', '附件')->image('/', 100, 100);;
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('name', '控制运行计划名称');
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

    public function form()
    {
        return Form::make(Scheduled::with([]), function (Form $form) {
            $form->text('name', '文件名称');
            $form->text('year', '年度');
            $form->select('type', '类型')->options(Scheduled::$typeMap);
            $form->file("file", '附件')->uniqueName()->autoSave(false)->autoUpload()->saveFullUrl();
            $form->hidden("project_id")->value(request()->get("id"));
            $form->hidden("project_type")->value(request()->get("type"));
            $form->hidden("admin_id")->value(\Admin::user()->id);
        });
    }
}
