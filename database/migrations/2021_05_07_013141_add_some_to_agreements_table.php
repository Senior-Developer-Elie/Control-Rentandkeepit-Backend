<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeToAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agreements', function (Blueprint $table) {
            $table->integer('term_length')->after('meta_key');

            $table->integer('start_date_day')->after('term_length');
            $table->integer('start_date_month')->after('start_date_day');
            $table->integer('start_date_year')->after('start_date_month');

            $table->float('rental_amount_total')->after('start_date_year')->default(0);

            $table->float('profit_total')->after('rental_amount_total')->default(0);
            $table->float('profit_per_week')->after('profit_total')->default(0);
            $table->float('profit_per_fortnight')->after('profit_per_week')->default(0);
            $table->float('profit_per_month')->after('profit_per_fortnight')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agreements', function (Blueprint $table) {
            //
        });
    }
}
