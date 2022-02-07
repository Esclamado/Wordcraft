<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalInformationInRefundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refund_requests', function (Blueprint $table) {
            $table->longText('additional_information')->nullable()->after('reason');
            $table->string('image')->after('additional_information')->nullable();
            $table->boolean('agreed_on_return_and_refund_policies')->default(0)->after('additional_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refund_requests', function (Blueprint $table) {
            $table->dropColumn(['additional_information', 'image', 'agreed_on_return_and_refund_policies']);
        });
    }
}
