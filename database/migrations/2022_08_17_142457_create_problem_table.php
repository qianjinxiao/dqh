<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name')->default('')->comment('项目名称');
            $table->string('title')->default('')->comment('反馈标题');
            $table->string('user_name')->default('')->comment('反馈人员');
            $table->tinyInteger('type')->default('1')->comment('类型1反馈2建议');
            $table->string('desc')->default('')->comment('反馈描述');
            $table->text('images')->comment('反馈照片');
            $table->integer('user_id');
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
        Schema::dropIfExists('problem');
    }
}
