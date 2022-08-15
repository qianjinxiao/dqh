<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_person')->nullable()->comment('上报人');
            $table->string('phone')->nullable()->comment('电话');
            $table->string('address')->nullable()->comment('险情位置');
            $table->string('lat')->nullable()->comment('险情位置经度');
            $table->string('lon')->nullable()->comment('险情位置纬度');
            $table->string('desc')->nullable()->comment('险情概况');
            $table->string('is_dispose')->nullable()->comment('是否处理');
            $table->string('file')->nullable()->comment('附件');
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
        Schema::dropIfExists('emergency_report');
    }
}
