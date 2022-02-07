<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountingDetailsInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('cr_number')->after('payment_reference')->nullable();
            $table->string('som_number')->after('cr_number')->nullable();
            $table->string('si_number')->after('som_number')->nullable();
            $table->string('dr_number')->after('si_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['cr_number', 'som_number', 'si_number', 'dr_number']);
        });
    }
}
