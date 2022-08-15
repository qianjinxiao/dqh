<?php

namespace App\Models;

use App\Models\Traits\ProjectCommon;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Water extends Model
{
	use HasDateTimeFormatter,ProjectCommon;
    protected $table = 'water';
    public function scopeByProject($query,ProjectInterface $project){
        return $query->where("project_id", $project->id)->where("project_type",get_class($project));
    }
}
