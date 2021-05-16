<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_id');
            $table->float('paid_amount')->default(0);
            $table->float('refund')->default(0);
            $table->integer('payment_method')->default(0);
            $table->integer('is_contract');
            
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
        Schema::dropIfExists('payment_histories');
    }
}
