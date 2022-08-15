<?php

namespace App\Admin\Actions\Grid;

use App\Models\Maintenance;
use App\Models\MaintenanceProject;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MaintenanceProjectComplete extends RowAction
{
    /**
     * @return string
     */
	protected $title = "<button class='btn btn-success '>完成</button>";

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
      $m=MaintenanceProject::query()->find($this->getKey());
        $m->is_complete=1;
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
		 return ['完成项目', '是否上报?'];
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
