<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDeclinedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_declined_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_declined_id')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('product_id')->index();

            $table->longText('variation')->nullable();
            $table->double('price', 20, 2);
            $table->double('tax', 20, 2);
            $table->double('shipping_cost', 20, 2);

            $table->integer('quantity')->nullable();

            $table->string('payment_status');
            $table->string('delivery_status')->nullable();
            $table->string('shipping_type')->nullable();

            $table->unsignedBigInteger('pickup_point_id')->nullable();
            $table->enum('order_type', ['advance_order', 'same_day_pickup']);

            $table->string('product_referral_code');

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
        Schema::dropIfExists('order_declined_details');
    }
}
