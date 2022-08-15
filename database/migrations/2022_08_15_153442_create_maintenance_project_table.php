<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_project', function (Blueprint $table) {
            $table->increments('id');
            $table->string('year')->default('')->comment('年份');
            $table->string('name')->default('')->comment('养护名称');
            $table->tinyInteger('type')->comment('类型 1年度 2日常');
            $table->dateTime('begin_at')->comment('计划开始时间');
            $table->dateTime('end_at')->comment('计划结束时间');
            $table->string('before_image')->default('')->comment('养护前图片');
            $table->string('after_image')->default('')->comment('养护后图片');
            $table->dateTime('completed_at')->comment('实际完成时间');
            $table->string('file')->default('')->comment('合同文件');
            $table->tinyInteger('is_push')->default(0)->comment('是否上报');
            $table->tinyInteger('is_complete')->default(0)->comment('是否完成');
            $table->integer('admin_id')->comment('上报人id');
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
        Schema::dropIfExists('maintenance_project');
    }
}
