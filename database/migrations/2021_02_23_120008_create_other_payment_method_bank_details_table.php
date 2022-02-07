<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherPaymentMethodBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_payment_method_bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('other_payment_method_id');
            $table->string('pickup_point_location');

            $table->string('bank_image');
            $table->string('bank_name');
            $table->string('bank_acc_name');
            $table->string('bank_acc_number');

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
        Schema::dropIfExists('other_payment_method_bank_details');
    }
}
