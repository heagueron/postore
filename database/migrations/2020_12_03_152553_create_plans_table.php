<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->unsignedInteger('value');
            $table->enum('show_logo',['on', null ])->default(null)->nullable();
            $table->enum('yellow_background',['on', null ])->default(null)->nullable();
            $table->enum('main_front_page',['on', null ])->default(null)->nullable();
            $table->enum('category_front_page',['on', null ])->default(null)->nullable();
            $table->string('gumroad_permalink')->nullable();
            $table->string('gumroad_product_id')->nullable();
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
        Schema::dropIfExists('plans');
    }
}
