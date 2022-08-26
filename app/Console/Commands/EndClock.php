<?php

namespace App\Console\Commands;

use App\Models\Inspect\InspectClock;
use App\Models\Inspect\InspectClockData;
use App\Models\User;
use App\Models\UserImei;
use App\Services\UserImeiService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EndClock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'end_clock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '关闭所有打卡';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        InspectClockData::query()->where('status',0)->get()->each(function($clock_data){

            $clock= InspectClock::query()->create([
                'time'=>Carbon::now(),
                'user_id'=>$clock_data->user_id,
                'report_status'=>2,//异常
                'project_id'=>$clock_data->project_id,
                'project_type'=>$clock_data->project_type,
                'lat'=>0,
                'lon'=>0,
            ]);
            $clock_data->end_clock_id=$clock->id;
            $clock_data->status=2;//异常退出
            $clock_data->save();
        });
    }
}
