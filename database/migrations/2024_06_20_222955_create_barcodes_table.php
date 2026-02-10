<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcodes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->string('name');
            $table->string('second_name');
            $table->string('description');
            $table->string('unit_type_id');
            $table->string('model');
            $table->string('factory_code');
            $table->string('barcode');
            $table->string('technical_specifications');
            $table->string('item_type_id');
            $table->string('internal_id');
            $table->string('item_code');
            $table->string('tienda_url');
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
        Schema::dropIfExists('barcodes');
    }
}
