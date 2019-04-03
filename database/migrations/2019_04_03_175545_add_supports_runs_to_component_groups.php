<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupportsRunsToComponentGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('component_groups', function (Blueprint $table) {
            $table->boolean('supports_runs')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('component_groups', function (Blueprint $table) {
            $table->dropColumn('supports_runs');
        });
    }
}
