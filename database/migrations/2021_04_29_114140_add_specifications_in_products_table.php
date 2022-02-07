<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecificationsInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('item_size')->nullable()->after('file_path');
            $table->string('item_unit_of_measurement')->after('item_size')->nullable();
            $table->string('package_length')->nullable()->after('item_unit_of_measurement');
            $table->string('package_weight')->nullable()->after('package_length');
            $table->string('package_height')->nullable()->after('package_weight');
            $table->string('package_width')->nullable()->after('package_height');
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
            $table->dropColumn(['item_size', 'item_unit_of_measurement', 'package_width', 'package_height', 'package_length', 'package_weight']);
        });
    }
}
