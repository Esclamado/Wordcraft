<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->integer('usage_limit')->nullable()->after('discount_type');
            $table->integer('usage_limit_user')->nullable()->after('usage_limit');
            $table->boolean('role_restricted')->default(0)->after('usage_limit_user');
            $table->string('roles')->nullable()->after('role_restricted');
            $table->boolean('individual_use')->default(0)->after('roles');
            $table->unsignedBigInteger('individual_user_id')->nullable()->after('individual_use');
            $table->boolean('bundle_coupon')->default(0)->after('individual_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['usage_limit', 'usage_limit_user', 'role_restricted', 'roles', 'individual_use', 'individual_user_id', 'bundle_coupon']);
        });
    }
}
