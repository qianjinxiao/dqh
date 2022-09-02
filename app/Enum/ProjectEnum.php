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
 * Time: 10:13
 */

namespace App\Enum;

use App\Models\DrinkingWater\DrinkingWater;
use App\Models\Farmland\Farmland;
use App\Models\Pool\Pool;
use App\Models\River\River;
use App\Models\SmallReservoirs\SmallReservoir;

class ProjectEnum
{

    const SMALL_RESERVOIR = "small_reservoir";
    const RIVER = "river";
    const POOL = "pool";
    const DRINKING_WATER = "drinking_water";
    const FARMLAND = "farmland";

    public static $allType = [
        self::SMALL_RESERVOIR,
        self::RIVER,
        self::POOL,
        self::DRINKING_WATER,
        self::FARMLAND,
    ];
    public static $allTypeMap = [
        SmallReservoir::class => '小型水库',
        River::class => '河道',
        Pool::class => '山塘',
        DrinkingWater::class => '农村饮用水',
        Farmland::class => '田地',
    ];
    public static $allTypeMap2 = [
        SmallReservoir::class => self::SMALL_RESERVOIR,
        River::class => self::RIVER,
        Pool::class => self::POOL,
        DrinkingWater::class => self::DRINKING_WATER,
        Farmland::class => self::FARMLAND,
    ];
    public static $project_list = [
        [
            'type' => self::SMALL_RESERVOIR,
            'name' => '小型水库'
        ],
        [
            'type' => self::RIVER,
            'name' => '河道'
        ],
        [
            'type' => self::POOL,
            'name' => '山塘'
        ],
        [
            'type' => self::DRINKING_WATER,
            'name' => '农村饮用水'
        ],
        [
            'type' => self::FARMLAND,
            'name' => '田地'
        ]

    ];
}
