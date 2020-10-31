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
            $table->string('company_slug');
            $table->string('position');
            $table->longText('text');
            $table->unsignedInteger('category_id');
            $table->string('apply_link');
            $table->integer('min_salary')->nullable();
            $table->integer('max_salary')->nullable();
            $table->string('locations');
            $table->string('company_logo')->nullable();
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
