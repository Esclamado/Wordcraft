<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResellerDiscountAndEmployeeDiscountInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->double('employee_discount', 20, 2)->nullable()->after('min_qty');
            $table->double('reseller_discount', 20, 2)->nullable()->after('employee_discount');
            $table->string('sku')->nullable()->after('variations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['employee_discount','reseller_discount','sku']);
        });
    }
}
