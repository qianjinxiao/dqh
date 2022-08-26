<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_nodes', function (Blueprint $table) {
            $table->id();
            $table->integer('check_id');
            $table->integer('line_id');
            $table->integer('region_id');
            $table->tinyInteger('is_check')->comment('是否检查')->default(0);
            $table->tinyInteger('is_problem')->comment('是否有问题')->default(0);
            $table->tinyInteger('is_push')->comment('是否上报')->default(0);
            $table->text('desc')->comment('问题描述')->nullable();
            $table->text('images')->comment('图片')->nullable();
            $table->text('videos')->comment('视频')->nullable();
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
        Schema::dropIfExists('check_nodes');

    }
}
