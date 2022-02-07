<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectiveItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defective_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pup_id');
            $table->string('sku');
            $table->string('defective_qty');
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
        Schema::table('defective_items', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('pup_id');
            $table->dropColumn('sku');
            $table->dropColumn('defective_qty');
        });
    }
}
