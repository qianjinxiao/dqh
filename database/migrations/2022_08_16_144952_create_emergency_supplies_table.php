<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencySuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_supplies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('储备点名称');
            $table->string('type')->default('')->comment('类别');
            $table->string('warehouse')->nullable()->comment('仓库面积(平方米)');
            $table->string('straw_bag')->nullable()->comment('草袋(万条)');
            $table->string('sacks')->nullable()->comment('麻袋(万条)');
            $table->string('woven_bag')->nullable()->comment('编织袋(万条)');
            $table->string('Inflation_bag')->nullable()->comment('膨胀袋(万条)');
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
        Schema::dropIfExists('emergency_supplies');
    }
}
