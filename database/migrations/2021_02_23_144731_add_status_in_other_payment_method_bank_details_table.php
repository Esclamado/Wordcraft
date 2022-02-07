<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusInOtherPaymentMethodBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_payment_method_bank_details', function (Blueprint $table) {
            $table->boolean('status')->default(false)->after('bank_acc_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('other_payment_method_bank_details', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
