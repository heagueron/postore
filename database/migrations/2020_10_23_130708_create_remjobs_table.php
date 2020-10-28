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
            $table->string('company_name')->unique();
            $table->string('company_slug')->unique();
            $table->string('position');
            $table->longText('text');
            $table->unsignedInteger('category_id');
            $table->string('apply_link');
            $table->boolean('show_salary');
            $table->enum('salary_type', ['yearly', 'monthly', 'weekly', 'hourly']);
            $table->integer('min_salary');
            $table->integer('max_salary');       
            $table->string('location');
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
