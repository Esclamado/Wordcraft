<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaynamicsTransactionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paynamics_transaction_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('notifiable_id');
            $table->enum('type', ['wallet', 'order']);

            $table->string('request_id');
            $table->string('response_id');
            $table->string('timestamp');
            $table->string('expiry_limit')->nullable();
            $table->string('pay_reference')->nullable();
            $table->json('direct_otc_info')->nullable();
            $table->string('signature')->nullable();
            $table->string('response_code');
            $table->string('response_message');
            $table->longText('response_advise');

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
        Schema::dropIfExists('paynamics_transaction_requests');
    }
}
