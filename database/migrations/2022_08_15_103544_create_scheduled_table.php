<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('year')->default('');
            $table->tinyInteger('type')->default('1')->comment('1报批稿 2批复搞');
            $table->string('file')->default('')->nullable();
            $table->string('admin_id')->nullable();
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
        Schema::dropIfExists('scheduled');
    }
}
