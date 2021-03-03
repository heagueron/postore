<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistinctVisitorsToDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dailies', function (Blueprint $table) {

            $table->unsignedInteger('distinct_visitors')->nullable()->after('hits_faq');

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
            $table->dropColumn('distinct_visitors');
        });
    }
}
