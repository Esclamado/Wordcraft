<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeInAffiliateWithdrawRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliate_withdraw_requests', function (Blueprint $table) {
            $table->enum('type', ['convert_to_wallet', 'withdraw_request'])->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_withdraw_requests', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
