<?php

namespace App\Admin\Actions\Grid;

use App\Admin\Forms\ImportsFarmlandInfoForm;
use App\Admin\Forms\ImportsGuestForm;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ImportFarmlandInfos extends AbstractTool
{
    /**
     * @return string
     */
	protected $title = 'Title';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function render()
    {
        $id = "import-guest-{$this->getKey()}";

        // 模态窗
        $this->modal($id);

                return <<<HTML
        <span class="grid-expand" data-toggle="modal" data-target="#{$id}">
           <a href="javascript:void(0)"><button class="btn btn-outline-info ">上传Excel并导入</button></a>
        </span>
        HTML;
    }
    protected function modal($id)
    {
        $form = new ImportsFarmlandInfoForm();
        Admin::script('Dcat.onPjaxComplete(function () {
            $(".modal-backdrop").remove();
            $("body").removeClass("modal-open");
        }, true)');

        // 通过 Admin::html 方法设置模态窗HTML
        Admin::html(
            <<<HTML
                <div class="modal fade" id="{$id}">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">导入数据</h4>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                      <div class="modal-body">
                      {$form->render()}
                      </div>
                    </div>
                  </div>
                </div>
                HTML
        );
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
