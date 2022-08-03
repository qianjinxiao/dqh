<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmallReservoirsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('small_reservoirs_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('job')->default('');
            $table->string('edu')->nullable();
            $table->string('professional')->nullable();
            $table->string('job_title')->nullable();
            $table->integer('small_reservoir_id')->index();
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
        Schema::dropIfExists('small_reservoirs_user');
    }
}
