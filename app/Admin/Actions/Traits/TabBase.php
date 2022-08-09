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
 * Date: 2022/8/3
 * Time: 14:23
 */

namespace App\Admin\Actions\Traits;

use App\Admin\Actions\Tab;
use App\Enum\ProjectEnum;
use App\Models\ProjectInterface;
use App\Models\SmallReservoirs\SmallReservoir;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Card;
use Illuminate\Support\Facades\Cache;
use App\Factory\ProjectFactory;

trait TabBase
{
    /**
     * Notes:使用tab公用配置方法
     * User: qianjinxiao
     * Date: 2022/8/3
     * Time: 14:26
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        $tab_class = "first_tab";
        $tab = Tab::make()->class($tab_class);
        $ts = Cache::get("tab_select_" . $tab_class);
        $n=0;
        foreach (self::$tabMap as $key=>$value){
            $tab->add($value, $this->tab($key), ($ts == $n) ? true : false);
            $n++;
        }
        return $content->body($tab->withCard());
    }
    public function tab($type)
    {
        $project=ProjectFactory::CreateProject($this->project_type);
        $tab_class = "second_tab";
        $tab = Tab::make()->class($tab_class);
        $n = 0;
        $ts = Cache::get("tab_select_" . $tab_class);
        $project::GetList()->each(function ($item) use ($tab, $type, &$n, $ts) {
            $bool = ($n == $ts) ? true : false;
            $tab->add($item->name, $this->custom_tab($item,$type), $bool);
            $n++;
        });
        return Card::make($tab);
    }
}
