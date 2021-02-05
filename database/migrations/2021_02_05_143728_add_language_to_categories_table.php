<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // 1. Create new column
            $table->unsignedBigInteger('language_id')->default(1)->nullable()->after('tag');

            // 2. Create foreign key constraints
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('SET NULL');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // 1. Drop foreign key constraints
            $table->dropForeign(['language_id']);

            // 2. Drop the column
            $table->dropColumn('language_id');
        });
    }
}
