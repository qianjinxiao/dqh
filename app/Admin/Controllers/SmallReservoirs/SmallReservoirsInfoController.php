<?php

namespace App\Admin\Controllers\SmallReservoirs;

//use App\Admin\Actions\Tab;
use App\Admin\Actions\Tab;
use App\Admin\Actions\Traits\TabBase;
use App\Admin\Interfaces\TabInterface;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\SmallReservoirs\SmallReservoirsInfo;
use App\Models\SmallReservoirs\SmallReservoirsUser;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SmallReservoirsInfoController extends AdminController implements TabInterface
{
    use TabBase;
    const  INFO = "info";
    const  USER = "user";
    protected static $tabMap = [
        self::INFO => "基本信息",
        self::USER => "人员岗位",
    ];
    public function custom_tab(SmallReservoir $item,string $type){
        switch ($type){
            case self::INFO:
                return $this->form($item->id);
            case self::USER:
                return $this->grid($item->id);
        }

    }

    protected function grid($id)
    {
        return Grid::make(new SmallReservoirsUser(), function (Grid $grid) use ($id) {
            $grid->model()->where("small_reservoir_id", $id);
            $grid->column('name', '姓名');
            $grid->column('job', '工作岗位');
            $grid->column('edu', '学历');
            $grid->column('professional', '专业');
            $grid->column('job_title', '职称');
            $grid->disableViewButton();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
            $grid->disableEditButton();
            $grid->setResource('small_reservoirs/user');
            $grid->model()->setConstraints([
                'small_reservoir_id' => $id,
            ]);

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id)
    {
        return Form::make(new SmallReservoirsInfo(), function (Form $form) use ($id) {
            $form->disableHeader();//隐藏头部
            $form->action("/small_reservoirs");
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
            $form->disableResetButton();
            $form->disableViewCheck();
            $form->column(6, function (Form $form) use ($id) {
                $form->hidden('small_reservoir_id')->value($id);
                $form->text('management_name', '单位管理名称')->width(8, 4);
                $form->text('management_head', '管理单位负责人')->width(8, 4);
                $form->text('management_worker_num', '管理单位职工总数')->width(8, 4)->type('number');
                $form->text('management_zip_code', '管理单位邮编')->width(8, 4)->type('number');
                $form->text('competent_department', '主管部门')->width(8, 4);
                $form->text('competent_department_name', '主管部门负责人')->width(8, 4);
                $form->text('competent_department_phone', '主管部门负责人手机')->width(8, 4)->type('number');
                $form->text('government_branch_name', '政府分管责任人')->width(8, 4);
                $form->text('government_name', '政府总责任人')->width(8, 4);
                $form->text('inspector_name', '巡查员姓名')->width(8, 4);

            });
            $form->column(6, function (Form $form) {
                $form->text('management_nature', '管理单位性质')->width(8, 4);
                $form->text('management_phone', '管理单位责任人电话')->width(8, 4)->type('number');
                $form->text('management_worker_on_guard_num', '管理单位职工在岗总数')->width(8, 4)->type('number');
                $form->text('management_address', '管理单位地址')->width(8, 4);
                $form->text('water_administration_department', '上级水行政主管部门')->width(8, 4);

                $form->text('competent_department_job', '主管部门负责人职务')->width(8, 4);
                $form->text('competent_department_unit', '主管部门负责人单位')->width(8, 4);
                $form->text('government_branch_job', '政府分管责任人职务')->width(8, 4);
                $form->text('government_job', '政府总责任人职务')->width(8, 4);
                $form->text('inspector_phone', '巡查员电话')->width(8, 4)->type('number');
            });

        });
    }
    public function update_info(Request $request)
    {
        $data = $request->only(['management_name', 'management_head', 'management_worker_num', 'management_zip_code', 'competent_department', 'competent_department_name',
            'competent_department_phone', 'government_branch_name', 'government_name', 'inspector_name',
            'management_nature', 'management_phone', 'management_worker_on_guard_num', 'management_address', 'water_administration_department',
            'competent_department_job', 'competent_department_unit', 'government_branch_job', 'government_job', 'inspector_phone'
        ]);
        SmallReservoirsInfo::query()->updateOrCreate(['small_reservoir_id' => $request->small_reservoir_id], $data);
        return JsonResponse::make()->success('成功！');
    }

    public function update_user(Request $request)
    {
        $data = $request->only(['small_reservoir_id', 'name', 'job', 'edu', 'professional', 'job_title']);
        SmallReservoirsUser::query()->updateOrCreate(['id' => $request->id], $data);
        return JsonResponse::make()->success('成功！');
    }

    public function delete_user($id)
    {
        SmallReservoirsUser::query()->where("id", $id)->delete();
        return JsonResponse::make()->success('成功！');
    }

    public function create_user()
    {
        return Form::make(new SmallReservoirsUser(), function (Form $form) {
            $form->action("/small_reservoirs/update_user");
            $form->display("id");
            $form->hidden('small_reservoir_id')->value(\request()->input("small_reservoir_id"));
            $form->text('name', '姓名');
            $form->text('job', '工作岗位');
            $form->text('edu', '学历');
            $form->text('professional', '专业');
            $form->text('job_title', '职称');
        });
    }

    public function edit_user($id = null)
    {
        return Form::make(new SmallReservoirsUser(), function (Form $form) use ($id) {
            $model = SmallReservoirsUser::query()->find($id);
            $form->action("/small_reservoirs/update_user");
            $form->hidden("id")->value($id);
            $form->hidden('small_reservoir_id')->value(\request()->input("small_reservoir_id"));
            $form->text('name', '姓名')->value($model->name);
            $form->text('job', '工作岗位')->value($model->job);
            $form->text('edu', '学历')->value($model->edu);
            $form->text('professional', '专业')->value($model->professional);
            $form->text('job_title', '职称')->value($model->job_title);

        });
    }

}
