<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellerCustomerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseller_customer_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('reseller_id');
            $table->unsignedBigInteger('customer_id');

            $table->string('order_code');
            $table->string('date');
            $table->string('number_of_products');
            $table->string('order_status');
            $table->string('payment_status');

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
        Schema::dropIfExists('reseller_customer_orders');
    }
}
