<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('order_payments', function (Blueprint $table) {
        $table->string('proof_of_payment')->nullable()->change();
        $table->string('cr_number')->nullable()->after('proof_of_payment');
        $table->string('payment_reference')->nullable()->after('cr_number');
        $table->integer('amount')->nullable()->after('payment_reference');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('order_payments', function (Blueprint $table) {
        $table->dropColumn(['cr_number']);
        $table->dropColumn(['payment_reference']);
        $table->dropColumn(['amount']);
    });
    }
}
