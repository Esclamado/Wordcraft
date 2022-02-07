<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentMethodLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('other_payment_methods', function (Blueprint $table) {
        $table->string('is_walkin')->default('0')->after('status');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('other_payment_methods', function (Blueprint $table) {
        $table->dropColumn(['is_walkin']);
      });
    }
}
