<?php
/**
 *
 * █████▒█    ██  ▄████▄   ██ ▄█▀       ██████╗ ██╗   ██╗ ██████╗
 * ▓██   ▒ ██  ▓██▒▒██▀ ▀█   ██▄█▒        ██╔══██╗██║   ██║██╔════╝
 * ▒████ ░▓██  ▒██░▒▓█    ▄ ▓███▄░        ██████╔╝██║   ██║██║  ███╗
 * ░▓█▒  ░▓▓█  ░██░▒▓▓▄ ▄██▒▓██ █▄        ██╔══██╗██║   ██║██║   ██║
 * ░▒█░   ▒▒█████▓ ▒ ▓███▀ ░▒██▒ █▄       ██████╔╝╚██████╔╝╚██████╔╝
 * ▒ ░   ░▒▓▒ ▒ ▒ ░ ░▒ ▒  ░▒ ▒▒ ▓▒       ╚═════╝  ╚═════╝  ╚═════╝
 * ░     ░░▒░ ░ ░   ░  ▒   ░ ░▒ ▒░
 * ░ ░    ░░░ ░ ░ ░        ░ ░░ ░
 * ░     ░ ░      ░  ░
 * Created by PhpStorm.
 * User: qianjinxiao
 * Date: 2022/8/8
 * Time: 10:16
 */

namespace App\Factory;

use App\Enum\ProjectEnum;
use App\Models\DrinkingWater\DrinkingWater;
use App\Models\Farmland\Farmland;
use App\Models\Pool\Pool;
use App\Models\ProjectInterface;
use App\Models\River\River;
use App\Models\SmallReservoirs\SmallReservoir;

class ProjectFactory
{
    public static function CreateProject(string $type):ProjectInterface
    {
        $project=null;
        switch ($type){
            case ProjectEnum::SMALL_RESERVOIR://小型水库
                $project= new SmallReservoir();
                break;
            case ProjectEnum::RIVER://小型水库
                $project= new River();
                break;
            case ProjectEnum::POOL://山塘
                $project= new Pool();
                break;
            case ProjectEnum::DRINKING_WATER://山塘
                $project= new DrinkingWater();
                break;
            case ProjectEnum::FARMLAND://田地
                $project= new Farmland();
                break;
        }
        return $project;
    }
    public static function CreateProjectForClass(string $type):ProjectInterface
    {
        $project=null;
        switch ($type){
            case SmallReservoir::class://小型水库
                $project= new SmallReservoir();
                break;
            case River::class://小型水库
                $project= new River();
                break;
            case Pool::class://山塘
                $project= new Pool();
                break;
            case DrinkingWater::class://山塘
                $project= new DrinkingWater();
                break;
            case Farmland::class://田地
                $project= new Farmland();
                break;
        }
        return $project;
    }

}
