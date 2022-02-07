<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentOptionInDeclinedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('declined_orders', function (Blueprint $table) {
            $table->enum('payment_option', ['paynamics', 'other-payment-method'])->after('pickup_point_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('declined_orders', function (Blueprint $table) {
            $table->dropColumn('payment_option');
        });
    }
}
