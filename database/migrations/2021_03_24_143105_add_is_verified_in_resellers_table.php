<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsVerifiedInResellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resellers', function (Blueprint $table) {
            $table->boolean('is_verified')->default(0)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resellers', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
}
