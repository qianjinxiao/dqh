<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectStatisticalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspect_statistical', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->comment('巡查对象id');
            $table->string('project_type')->default('')->comment('巡查对象');
            $table->dateTime('clock_date')->comment('打卡日期');
            $table->integer('user_id')->default('0')->comment('操作人员id');
            $table->tinyInteger('status')->default('0')->comment('0未巡查 1已巡查');
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
        Schema::dropIfExists('inspect_statistical');
    }
}
