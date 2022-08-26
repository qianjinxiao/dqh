<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->id();
            $table->integer('inspect_data_id')->comment('巡查id');
            $table->dateTime('date')->comment('日期');
            $table->string('weather')->comment('天气')->nullable();
            $table->string('water')->comment('水位')->nullable();
            $table->string('user_name')->comment('巡查员')->nullable();
            $table->string('duty_name')->comment('责任人')->nullable();
            $table->integer('user_id');
            $table->text('content')->comment('巡查结论')->nullable();
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
        Schema::dropIfExists('checks');

    }
}
