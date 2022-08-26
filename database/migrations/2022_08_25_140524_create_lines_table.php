<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->id();
            $table->integer('region_id')->comment('区域');
            $table->string('name')->comment('部位');
            $table->integer('order')->comment('排序')->default(0);
            $table->timestamps();
            $table->integer('type');
            $table->integer('admin_id')->comment('上报人id');
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
        Schema::dropIfExists('lines');
    }
}
