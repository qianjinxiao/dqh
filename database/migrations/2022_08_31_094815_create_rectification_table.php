<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRectificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rectification', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date')->default('');
            $table->string('address')->nullable();
            $table->string('content')->nullable();
            $table->tinyInteger('status')->default('0');
            $table->string('admin_id')->nullable();
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
        Schema::dropIfExists('rectification');
    }
}
