<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxQuantityOnCouponBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_bundles', function (Blueprint $table) {
            $table->integer('product_quantity_max')->after('product_quantity')->default(0);
        });

        Schema::table('coupon_category_bundles', function (Blueprint $table) {
            $table->integer('category_quantity_max')->after('category_quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_bundles', function (Blueprint $table) {
            $table->dropColumn('product_quantity_max');
        });

        Schema::table('coupon_category_bundles', function (Blueprint $table) {
            $table->dropColumn('category_quantity_max');
        });
    }
}
