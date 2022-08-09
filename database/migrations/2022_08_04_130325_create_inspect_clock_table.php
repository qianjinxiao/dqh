<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectClockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspect_clock', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('time');
            $table->integer('user_id');
            $table->string('water_level')->default('');
            $table->string('address')->default('');
            $table->tinyInteger('report_status');
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
        Schema::dropIfExists('inspect_clock');
    }
}
