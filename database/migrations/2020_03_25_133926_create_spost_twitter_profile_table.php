<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpostTwitterProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spost_twitter_profile', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->id();
            $table->unsignedBigInteger('spost_id');
            $table->unsignedBigInteger('twitter_profile_id');
            $table->unsignedBigInteger('twitter_status_id')->nullable();
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
        Schema::dropIfExists('spost_twitter_profile');
    }
}
