<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentStatusFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_status_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reseller_id');
            $table->string('img_type');
            $table->string('img');
            $table->timestamps();
            // $table->foreign('reseller_id')->references('id')->on('resellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employment_status_files');
    }
}
