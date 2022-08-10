<?php

namespace App\Http\Requests;

use App\Enum\ProjectEnum;

class InspectClockRequest extends FormRequest
{
    public function rules()
    {
        $type=ProjectEnum::$allType;
        return [
            'project_type' => 'required|string|in:'.implode(',',$type),
            'project_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'project_type' => '打卡点位',
            'project_id' => '点位id',
        ];
    }
}
