<?php

namespace App\Models;

use App\Models\Traits\ProjectCommon;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class MaintenanceTrouble extends Model
{
    use HasDateTimeFormatter,ProjectCommon;

    protected $table = 'maintenance_trouble';
    public static $processStateMap = [
        1 => '问题分析/维修申请',
        2 => '维修申请审批',
        3 => '维修结果记录',
        4 => '结果审核',
    ];
    public static $foundTypeMap = [
        1 => '日常巡查',
        2 => '汛前检查',
        3 => '年度检查',
        4 => '特别检查',
        5 => '全岛检查',
        6 => '上级防汛检查',
        7 => '防汛督查',
        8 => '安全评估',
        9 => '观测资料分析',
        10 => '日常观测',
        11 => '其他',
    ];
    public static $processMoodMap = [
        1 => '日常跟踪',
        2 => '通过日常维修养护解决',
        3 => '通过年度大修解决',
        4 => '申请列入综合整治计划',
        5 => '请求提供技术指导',
        6 => '其他',
    ];
    public static $processStatusMap = [
        0 => '未审批',
        1 => '同意',
        2 => '拒绝',
    ];

}
