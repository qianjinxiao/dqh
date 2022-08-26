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

use App\Models\SmallReservoirs\SmallReservoir;

class ProjectEnum
{

    const SMALL_RESERVOIR = "small_reservoir";
    const RIVER = "river";
    const POOL = "pool";
    const DRINKING_WATER = "drinking_water";

    public static $allType = [
        self::SMALL_RESERVOIR,
        self::RIVER,
        self::POOL,
        self::DRINKING_WATER,
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
        ]

    ];
}
