<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspect_data', function (Blueprint $table) {
            $table->id();
            $table->integer('start_clock_id')->comment("巡查开始id");
            $table->integer('end_clock_id')->nullable()->comment("巡查结束id");
            $table->integer('project_id');
            $table->string('project_type')->default('');
            $table->integer('user_id');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('inspect_data');
    }
}
