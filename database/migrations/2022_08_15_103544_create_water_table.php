<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->dateTime('begin_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->integer('admin_id');
            $table->string('option')->nullable()->comment('操作人');
            $table->string('principal')->nullable()->comment('负责人');
            $table->text('desc')->nullable()->comment('完成情况');
            $table->string('file')->nullable()->comment('附件');
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
        Schema::dropIfExists('water');
    }
}
