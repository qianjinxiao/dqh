<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmlandInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmland_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('villagers')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->nullable();
            $table->string('mj1')->nullable();
            $table->string('mj2')->nullable();
            $table->string('mj3')->nullable();
            $table->string('mj4')->nullable();
            $table->string('mj5')->nullable();
            $table->string('quo')->nullable();
            $table->text('desc')->nullable();
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
        Schema::dropIfExists('farmland_infos');
    }
}
