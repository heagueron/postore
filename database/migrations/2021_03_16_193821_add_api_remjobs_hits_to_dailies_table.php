<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiRemjobsHitsToDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dailies', function (Blueprint $table) {
            $table->unsignedInteger('hits_api_remjobs')->default(0);
            $table->unsignedInteger('hits_api_remjobs_pro')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dailies', function (Blueprint $table) {
            $table->dropColumn('hits_api_remjobs');
            $table->dropColumn('hits_api_remjobs_pro');
        });
    }
}
