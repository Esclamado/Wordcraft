<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_status')->nullable()->after('payment_status');
            $table->string('request_status')->nullable()->after('order_status');
            $table->tinyInteger('is_walkin')->nullable()->after('request_status');
            $table->string('reason_type')->nullable()->after('is_walkin');
            $table->string('reason_field')->nullable()->after('reason_type');
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
            $table->dropColumn(['order_status']);
            $table->dropColumn(['request_status']);
            $table->dropColumn(['is_walkin']);
            $table->dropColumn(['reason_type']);
            $table->dropColumn(['reason_field']);
        });
    }
}
