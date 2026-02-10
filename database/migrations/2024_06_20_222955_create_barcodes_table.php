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
            $table->string('currency_type_id');
            $table->decimal('sale_unit_price', 12, 4);
            $table->decimal('print_price', 12, 4);

            $table->string('p1_unit_type_id');
            $table->decimal('p1_quantity_unit', 12, 4);
            $table->decimal('p1_price1', 12, 4);
            $table->decimal('p1_price2', 12, 4);
            $table->decimal('p1_price3', 12, 4);
            $table->decimal('p1_price_default', 12, 4);

            $table->string('p2_unit_type_id');
            $table->decimal('p2_quantity_unit', 12, 4);
            $table->decimal('p2_price1', 12, 4);
            $table->decimal('p2_price2', 12, 4);
            $table->decimal('p2_price3', 12, 4);
            $table->decimal('p2_price_default', 12, 4);

            $table->string('p3_unit_type_id');
            $table->decimal('p3_quantity_unit', 12, 4);
            $table->decimal('p3_price1', 12, 4);
            $table->decimal('p3_price2', 12, 4);
            $table->decimal('p3_price3', 12, 4);
            $table->decimal('p3_price_default', 12, 4);
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
