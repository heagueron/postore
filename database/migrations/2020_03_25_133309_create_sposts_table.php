<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sposts', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->bigIncrements('id');
            $table->string('text');
            $table->timestamp('post_date')->nullable();
            $table->boolean('posted')->default(false);
            $table->unsignedInteger('user_id');
            $table->string('media_1')->nullable();
            $table->string('media_2')->nullable();
            $table->string('media_3')->nullable();
            $table->string('media_4')->nullable();
            $table->unsignedInteger('media_files_count')->default(0);
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
        Schema::dropIfExists('sposts');
    }
}
