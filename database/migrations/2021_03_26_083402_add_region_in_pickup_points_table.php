<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionInPickupPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pickup_points', function (Blueprint $table) {
            $table->enum('region', ['north_luzon', 'south_luzon', 'visayas', 'mindanao'])->after('cash_on_pickup_status')->nullable();
            $table->enum('type', ['warehouse', 'branch'])->after('region')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pickup_points', function (Blueprint $table) {
            $table->dropColumn(['region', 'type']);
        });
    }
}
