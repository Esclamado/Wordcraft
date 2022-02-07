<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeInPaynamicsQueryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paynamics_query_requests', function (Blueprint $table) {
            $table->enum('type', ['order', 'wallet'])->after('order_id')->default('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paynamics_query_requests', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
