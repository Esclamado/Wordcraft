<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCategoryBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_category_bundles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('category_quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_category_bundles');
    }
}
