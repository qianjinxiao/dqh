<?php

namespace App\Admin\Controllers\SmallReservoirs;


use App\Admin\Actions\Traits\TabBase;
use App\Admin\Controllers\ProjectUserController;
use App\Admin\Interfaces\TabInterface;
use App\Enum\ProjectEnum;
use App\Models\ProjectInterface;
use App\Models\SmallReservoirs\SmallReservoir;
use App\Models\SmallReservoirs\SmallReservoirsInfo;
use App\Models\SmallReservoirs\SmallReservoirsUser;
use App\Services\InspectStatisticalService;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\JsonResponse;


use Dcat\Admin\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use function PHPUnit\Framework\throwException;

/**
 * 基础信息
 */
class SmallReservoirsInfoController extends AdminController implements TabInterface
{
    use TabBase;
    public $project_type=ProjectEnum::SMALL_RESERVOIR;//第一层tab

    const  INFO = "info";
    const  USER = "user";
    protected static $tabMap = [
        self::INFO => "基本信息",
        self::USER => "人员岗位",
    ];

    public function custom_tab(ProjectInterface $item, string $type)
    {
        switch ($type) {
            case self::INFO:
                return $this->form($item->id);
            case self::USER:
                return (new ProjectUserController())->grid($item->id,get_class($item));
        }

    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($id)
    {
        return Form::make( SmallReservoirsInfo::with([]), function (Form $form) use ($id) {
            $m=SmallReservoirsInfo::query()->where('small_reservoir_id',$id)->first();
            $form->disableHeader();//隐藏头部
            $form->action("/small_reservoirs");
            $form->disableEditingCheck();
            $form->disableCreatingCheck();
            $form->disableResetButton();
            $form->disableViewCheck();
            $form->column(6, function (Form $form) use ($id,$m) {

                $form->hidden('small_reservoir_id')->value($id);
                $form->text('management_name', '单位管理名称')->width(8, 4)->value($m->management_name??'');
                $form->text('management_head', '管理单位负责人')->width(8, 4)->value($m->management_head??'');
                $form->text('management_worker_num', '管理单位职工总数')->width(8, 4)->type('number')->value($m->management_worker_num??'');
                $form->text('management_zip_code', '管理单位邮编')->width(8, 4)->type('number')->value($m->management_zip_code??'');
                $form->text('competent_department', '主管部门')->width(8, 4)->value($m->competent_department??'');
                $form->text('competent_department_name', '主管部门负责人')->width(8, 4)->value($m->competent_department_name??'');
                $form->text('competent_department_phone', '主管部门负责人手机')->width(8, 4)->type('number')->value($m->competent_department_phone??'');
                $form->text('government_branch_name', '政府分管责任人')->width(8, 4)->value($m->government_branch_name??'');
                $form->text('government_name', '政府总责任人')->width(8, 4)->value($m->government_name??'');
                $form->text('inspector_name', '巡查员姓名')->width(8, 4)->value($m->inspector_name??'');

            });
            $form->column(6, function (Form $form) {
                $form->text('management_nature', '管理单位性质')->width(8, 4)->value($m->management_nature??'');;
                $form->text('management_phone', '管理单位责任人电话')->width(8, 4)->type('number')->value($m->management_phone??'');;
                $form->text('management_worker_on_guard_num', '管理单位职工在岗总数')->width(8, 4)->type('number')->value($m->management_worker_on_guard_num??'');;
                $form->text('management_address', '管理单位地址')->width(8, 4)->value($m->management_address??'');
                $form->text('water_administration_department', '上级水行政主管部门')->width(8, 4)->value($m->water_administration_department??'');;

                $form->text('competent_department_job', '主管部门负责人职务')->width(8, 4)->value($m->competent_department_job??'');;
                $form->text('competent_department_unit', '主管部门负责人单位')->width(8, 4)->value($m->competent_department_unit??'');;
                $form->text('government_branch_job', '政府分管责任人职务')->width(8, 4)->value($m->government_branch_job??'');;
                $form->text('government_job', '政府总责任人职务')->width(8, 4)->value($m->government_job??'');;
                $form->text('inspector_phone', '巡查员电话')->width(8, 4)->type('number')->value($m->inspector_phone??'');;
            });

        });
    }

    public function update_info(Request $request)
    {
        try {
            $data = $request->only(['management_name', 'management_head', 'management_worker_num', 'management_zip_code', 'competent_department', 'competent_department_name',
                'competent_department_phone', 'government_branch_name', 'government_name', 'inspector_name',
                'management_nature', 'management_phone', 'management_worker_on_guard_num', 'management_address', 'water_administration_department',
                'competent_department_job', 'competent_department_unit', 'government_branch_job', 'government_job', 'inspector_phone'
            ]);
            SmallReservoirsInfo::query()->updateOrCreate(['small_reservoir_id' => $request->small_reservoir_id], $data);
            return JsonResponse::make()->success('成功！');
        } catch (\Exception $e) {
            abort(500, "服务器异常");
        }

    }
}
