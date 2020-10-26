<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remjobs', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->id();
            $table->string('company_name');
            $table->string('position');
            $table->longText('text');
            $table->unsignedInteger('category_id');
            $table->string('location');
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
        Schema::dropIfExists('remjobs');
    }
}
