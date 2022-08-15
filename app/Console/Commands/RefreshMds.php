<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserImei;
use App\Services\UserImeiService;
use App\Services\UserService;
use Illuminate\Console\Command;

class RefreshMds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh_mds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '刷新mds';

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
        User::query()->whereNotNull("mds")->get()->each(function ($item){
            UserImeiService::getInstance()->refresh_mds($item);
        });
    }
}
