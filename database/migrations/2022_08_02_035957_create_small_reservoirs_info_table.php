<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmallReservoirsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('small_reservoirs_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('small_reservoir_id')->nullable()->comment('小型水库id');
            $table->string('management_name')->nullable()->comment('单位管理名称');
            $table->string('management_nature')->nullable()->comment('管理单位性质');
            $table->string('management_head')->nullable()->comment('管理单位负责人');
            $table->string('management_phone')->nullable()->comment('管理单位责任人电话');
            $table->integer('management_worker_num')->nullable()->comment('管理单位职工总数');
            $table->integer('management_worker_on_guard_num')->nullable()->comment('管理单位职工在岗总数');
            $table->integer('management_zip_code')->nullable()->comment('管理单位邮编');
            $table->string('management_address')->nullable()->comment('管理单位地址');
            $table->string('competent_department')->nullable()->comment('主管部门');
            $table->string('water_administration_department')->nullable()->comment('上级水行政主管部门');
            $table->string('competent_department_name')->nullable()->comment('主管部门负责人');
            $table->string('competent_department_job')->nullable()->comment('主管部门负责人职务');
            $table->string('competent_department_phone')->nullable()->comment('主管部门负责人手机');
            $table->string('competent_department_unit')->nullable()->comment('主管部门负责人单位');
            $table->string('government_branch_name')->nullable()->comment('政府分管责任人');
            $table->string('government_branch_job')->nullable()->comment('政府分管责任人职务');
            $table->string('government_name')->nullable()->comment('政府总责任人');
            $table->string('government_job')->nullable()->comment('政府总责任人职务');
            $table->string('inspector_name')->nullable()->comment('巡查员姓名');
            $table->string('inspector_phone')->nullable()->comment('巡查员电话');
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
        Schema::dropIfExists('small_reservoirs_info');
    }
}
