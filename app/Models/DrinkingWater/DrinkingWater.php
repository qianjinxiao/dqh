<?php

namespace App\Models\DrinkingWater;

use App\Models\ProjectInterface;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class DrinkingWater extends Model implements ProjectInterface
{
	use HasDateTimeFormatter;
    protected $table = 'drinking_water';

    public static function GetList()
    {
        return DrinkingWater::query()->get();
    }
}
