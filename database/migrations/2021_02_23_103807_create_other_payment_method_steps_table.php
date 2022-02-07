<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherPaymentMethodStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_payment_method_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('other_payment_method_id');
            $table->foreign('other_payment_method_id')->references('id')->on('other_payment_methods')->onDelete('cascade');
            $table->string('step');
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
        Schema::dropIfExists('other_payment_method_steps');
    }
}
