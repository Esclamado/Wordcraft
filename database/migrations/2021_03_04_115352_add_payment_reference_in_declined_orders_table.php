<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentReferenceInDeclinedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('declined_orders', function (Blueprint $table) {
            $table->timestamp('paid_at')->after('commission_calculated')->nullable();
            $table->string('payment_reference')->after('paid_at')->nullable();
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
            $table->dropColumn('paid_at');
            $table->dropColumn('payment_reference');
        });
    }
}
