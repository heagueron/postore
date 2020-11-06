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
            $table->string('position');
            $table->longText('description');
            $table->unsignedInteger('category_id')->nullable();
            $table->integer('min_salary')->nullable();
            $table->integer('max_salary')->nullable();
            $table->string('locations')->nullable();
            $table->string('apply_link')->nullable();
            $table->string('apply_email')->nullable();
            $table->enum('apply_mode',['link', 'email'])->default('link');
            $table->string('company_name');
            $table->string('company_slug');
            $table->string('company_email');
            $table->string('company_twitter')->nullable();
            $table->string('company_logo')->nullable();

            $table->enum('show_logo',['on', null ])->default(null)->nullable();

            $table->enum('highlight_yellow',['on', null ])->default(null)->nullable();

            $table->enum('front_page_2w',['on', null ])->default(null)->nullable();

            $table->enum('front_category_2w',['on', null ])->default(null)->nullable();

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
