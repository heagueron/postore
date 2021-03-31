<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTwitterIdFromTwitterPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('twitter_posts', function (Blueprint $table) {
            $table->dropColumn('tweet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('twitter_posts', function (Blueprint $table) {
            $table->unsignedInteger('tweet_id')->nullable()->after('remjob_id');
        });
    }
}
