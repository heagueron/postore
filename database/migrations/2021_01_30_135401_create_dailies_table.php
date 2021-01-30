<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailies', function (Blueprint $table) {
            $table->id();
            $table->date('track_day');
            $table->unsignedInteger('hits_landing')->nullable();
            $table->unsignedInteger('hits_category')->nullable();
            $table->unsignedInteger('hits_details')->nullable();
            $table->unsignedInteger('hits_faq')->nullable();
            $table->unsignedInteger('registered_users')->nullable();
            $table->unsignedInteger('sales_p1')->nullable();
            $table->unsignedInteger('sales_p2')->nullable();
            $table->unsignedInteger('sales_p3')->nullable();
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
        Schema::dropIfExists('dailies');
    }
}
