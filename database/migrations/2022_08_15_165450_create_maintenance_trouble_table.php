<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceTroubleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_trouble', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('设备名称');
            $table->string('address')->nullable()->comment('所在地点');
            $table->string('code')->nullable()->comment('编码');
            $table->integer('found_type')->default('1')->nullable()->comment('发现方式');
            $table->dateTime('found_at')->nullable()->comment('发现时间');
            $table->string('found_people')->nullable()->comment('发现人');
            $table->text('defect_content')->nullable()->comment('缺陷内容');
            $table->string('image')->nullable()->comment('照片');
            $table->dateTime('plan_completed_at')->nullable()->comment('计划治理完成时间');
            $table->string('rid_people')->nullable()->comment('消缺人');
            $table->string('rid_phone')->nullable()->comment('消缺人电话');
            $table->integer('process_mode')->default('1')->nullable()->comment('处理方式');
            $table->integer('status')->default('0')->nullable()->comment('审批状态');
            $table->dateTime('completed_at')->nullable()->comment('实际完成时间');
            $table->string('complete_image')->nullable()->comment('照片');
            $table->text('opinion')->nullable()->comment('意见');
            $table->string('note')->nullable()->comment('短信内容');
            $table->string('recipient')->nullable()->comment('接收人');
            $table->tinyInteger('is_send')->nullable()->default(0)->comment('是否发送');
            $table->integer('process_state')->default(1)->comment('流程状态');
            $table->integer('admin_id')->comment('上报人id');
            $table->integer('project_id');
            $table->string('project_type')->default('');
            $table->tinyInteger('is_push_yh')->default(0)->comment('上报隐患');
            $table->tinyInteger('is_push_result')->default(0)->comment('上报处理结果');
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
        Schema::dropIfExists('maintenance_trouble');
    }
}
