<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentExchangeRatesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_payment_exchange_rates', function(Blueprint $table)
        {
            $table->increments('id');
            $table->float('value');
            $table->float('amount');
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
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
        Schema::drop('premium_payment_exchange_rates');
    }

}