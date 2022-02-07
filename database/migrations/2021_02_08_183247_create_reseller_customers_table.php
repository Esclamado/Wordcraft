<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellerCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseller_customers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('reseller_id');
            $table->unsignedBigInteger('customer_id');

            $table->integer('total_orders')->default(0);

            $table->timestamp('last_order_date');
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
        Schema::dropIfExists('reseller_customers');
    }
}
