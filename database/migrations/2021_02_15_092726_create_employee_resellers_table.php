<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeResellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_resellers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('reseller_id');

            $table->integer('total_successful_orders')->default(0);
            $table->double('total_earnings', 8, 2);

            $table->double('remaining_purchase_to_be_verified', 8, 2)->default(10000.00);
            $table->boolean('is_verified')->default(0);

            $table->timestamp('date_of_sign_up');
            $table->timestamp('date_joined');
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
        Schema::dropIfExists('employee_resellers');
    }
}
