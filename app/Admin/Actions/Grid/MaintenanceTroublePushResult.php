<?php

namespace App\Admin\Actions\Grid;

use App\Models\MaintenanceTrouble;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MaintenanceTroublePushResult extends RowAction
{
    /**
     * @return string
     */
    protected $title = "<button class='btn btn-dark '>上报处理结果</button>&nbsp;";

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $m=MaintenanceTrouble::query()->find($this->getKey());
        $m->is_push_result=1;
        $m->save();
        return $this->response()
            ->success('Processed successfully: '.$this->getKey())
            ->refresh();
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		// return ['Confirm?', 'contents'];
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
