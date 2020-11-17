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
            
            $table->unsignedInteger('company_id')->nullable();

            $table->enum('show_logo',['on', null ])->default(null)->nullable();
            $table->enum('highlight_yellow',['on', null ])->default(null)->nullable();
            $table->enum('front_page_2w',['on', null ])->default(null)->nullable();
            $table->enum('front_category_2w',['on', null ])->default(null)->nullable();

            $table->boolean('active')->default(0);
            $table->boolean('paid')->default(0);
            $table->string('gumroad_license')->nullable();
            $table->string('gumroad_product_id')->nullable();

            $table->integer('total')->nullable();
            $table->string('gumroad_link')->nullable();

            $table->string('external_api')->nullable();

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
