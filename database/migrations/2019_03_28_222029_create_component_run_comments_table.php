<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentRunCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_run_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('component_run_id');
            $table->integer('type')->default(0);
            $table->string('comment');
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->index('component_run_id');
            $table->index('type');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('component_run_comments');
    }
}
