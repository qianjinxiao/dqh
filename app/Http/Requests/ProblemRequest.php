<?php

namespace App\Http\Requests;

class ProblemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'project_name' => 'required|string',
            'title' => 'required|string',
            'user_name' => 'required|string',
            'type' => 'required|in:1,2',
            'desc' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'project_name' => '项目名称',
            'title' => '反馈标题',
            'user_name' => '反馈人员',
            'type' => '类型',
            'desc' => '反馈描述',
        ];
    }
}
