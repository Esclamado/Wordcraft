<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('unique_id');
            $table->string('name');

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->enum('type', ['single_payment_option', 'multiple_payment_option', 'e_wallet']);

            $table->boolean('follow_up_instruction')->default(false);

            $table->boolean('status')->default(false);

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
        Schema::dropIfExists('other_payment_methods');
    }
}
