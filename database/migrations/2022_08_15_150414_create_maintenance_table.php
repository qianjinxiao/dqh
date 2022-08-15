<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->increments('id');
            $table->string('year')->default('')->comment('年份');
            $table->float('declaration_money')->comment('申报资金（万元/年）');
            $table->float('top_money')->comment('上级下达资金(万元)');
            $table->float('self_raised_money')->comment('自筹资金(万元)');
            $table->float('actual_completed_money')->comment('实际完成资金(万元)');
            $table->float('payed_money')->comment('已支付资金(万元)');
            $table->string('declaration_file')->default('')->comment('申报文件')->nullable();
            $table->string('plan_file')->default('')->comment('计划文件')->nullable();
            $table->integer('project_id');
            $table->string('project_type')->default('');
            $table->integer('admin_id')->comment('上报人id');
            $table->tinyInteger('is_push')->comment('是否上报')->default(0);
            $table->integer('project_id');
            $table->string('project_type')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance');
    }
}
