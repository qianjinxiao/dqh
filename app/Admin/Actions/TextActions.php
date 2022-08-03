<?php

namespace App\Admin\Actions;

use Dcat\Admin\Grid\Displayers\Actions;

class TextActions extends Actions
{

    /**
     * @return string
     */
    protected function getViewLabel()
    {
        $label = trans('admin.show') ;
        return '<button class="btn btn-outline-info">' . $label . '</button> &nbsp;';
    }

    /**
     * @return string
     */
    protected function getEditLabel()
    {
        $label = trans('admin.edit') ;
        return '<button class="btn btn-outline-warning">' . $label . '</button> &nbsp;';
    }

    /**
     * @return string
     */
    protected function getQuickEditLabel()
    {
        $label = trans('admin.edit') ;
        $label2 = trans('admin.quick_edit');
        if(in_array('customers',explode('/',request()->url()))){
            return '<button class="btn btn-outline-warning" title="' . $label2 . '">完善客户资料</button> &nbsp;';
        };
        return '<button class="btn btn-outline-warning" title="' . $label2 . '">' . $label . '</button> &nbsp;';

    }

    /**
     * @return string
     */
    protected function getDeleteLabel()
    {
        $label = trans('admin.delete') ;

        return '<button class="btn btn-outline-danger">' . $label . '</button> &nbsp;';
    }
}
