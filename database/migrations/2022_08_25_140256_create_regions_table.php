<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('区域');
            $table->integer('order')->comment('排序')->default(0);
            $table->timestamps();
            $table->integer('admin_id')->comment('上报人id');
            $table->integer('type')->comment('1日常 2汛前 3特别 4年度')->default(1);
            $table->integer('project_id');
            $table->string('project_type')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
