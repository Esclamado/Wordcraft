<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancelledOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declined_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');

            $table->string('order_code');
            $table->string('pickup_point_location');
            $table->string('payment_type');
            $table->string('payment_details')->nullable();

            $table->double('grand_total', 20, 2);
            $table->double('coupon_discount', 20, 2);

            $table->text('date_order_placed');

            $table->boolean('viewed')->default(false);
            $table->boolean('delivery_viewed')->default(false);
            $table->boolean('payment_status_viewed')->default(false);
            $table->boolean('commission_calculated')->default(false);

            $table->text('reason')->nullable();

            $table->timestamp('date_declined');
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
        Schema::dropIfExists('declined_orders');
    }
}
