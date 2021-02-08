<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailchimpToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // 1. Create new columns
	        $table->string('mailchimp_audience_id')->default('f52a8f2e25')->nullable();
            $table->string('mailchimp_category_id')->nullable();
            $table->string('mailchimp_interest_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // 2. Drop the columns
            $table->dropColumn('mailchimp_audience_id');
            $table->dropColumn('mailchimp_category_id');
            $table->dropColumn('mailchimp_interest_id');
        });
    }
}
