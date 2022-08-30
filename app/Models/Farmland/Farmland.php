<?php

namespace App\Models\Farmland;

use App\Models\DrinkingWater\DrinkingWater;
use App\Models\ProjectInterface;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Farmland extends Model implements ProjectInterface
{
    use HasDateTimeFormatter;
    protected $table = 'farmlands';
    public static function GetList()
    {
        return Farmland::query()->get();
    }
}
