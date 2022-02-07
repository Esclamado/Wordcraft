<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderEditDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_edit_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->string('seller_id')->nullable();
            $table->string('product_id');
            $table->string('variation')->nullable();
            $table->double('price', 20, 2)->nullable();
            $table->double('tax', 20, 2);
            $table->double('shipping_cost', 20, 2);
            $table->string('quantity')->nullable();
            $table->string('partial_released_qty')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->tinyInteger('is_edit')->nullable()->comment('For identifying additional orders(walkin)');
            $table->tinyInteger('is_deleted')->nullable()->comment('For identifying deleted item(walkin)');
            $table->string('delivery_status')->default('pending');
            $table->string('shipping_type')->nullable();
            $table->string('pickup_point_id')->nullable();
            $table->enum('order_type', ['advance_order', 'same_day_pickup'])->nullable();
            $table->string('product_refferal_code')->nullable();
            $table->tinyInteger('partial_released')->default(0);
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
        Schema::table('order_edit_details', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('order_id');
            $table->dropColumn('seller_id');
            $table->dropColumn('product_id');
            $table->dropColumn('variation');
            $table->dropColumn('price', 20, 2);
            $table->dropColumn('tax', 20, 2);
            $table->dropColumn('shipping_cost', 20, 2);
            $table->dropColumn('quantity');
            $table->dropColumn('partial_released_qty');
            $table->dropColumn('payment_status');
            $table->dropColumn('is_edit');
            $table->dropColumn('delivery_status');
            $table->dropColumn('shipping_type');
            $table->dropColumn('pickup_point_id');
            $table->dropColumn('product_refferal_code');
            $table->dropColumn('partial_released');
        });
    }
}
