<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('文件名称');
            $table->string('unit')->nullable()->comment('编制单位');
            $table->string('address')->nullable()->comment('地区');
            $table->dateTime('compiled_at')->nullable()->comment('编制时间');
            $table->string('file')->nullable()->comment('附件');
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
        Schema::dropIfExists('emergency_plan');
    }
}
