<?php

namespace App\Models\Pool;

use App\Models\ProjectInterface;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model implements ProjectInterface
{
	use HasDateTimeFormatter;
    protected $table = 'pool';

    public static function GetList()
    {
        return Pool::query()->get();
    }
}
