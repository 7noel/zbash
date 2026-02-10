<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;
        
    protected $fillable = ['item_id', 'name', 'second_name', 'description', 'unit_type_id', 'model', 'factory_code', 'barcode', 'technical_specifications', 'item_type_id', 'internal_id', 'item_code', 'tienda_url', 'currency_type_id', 'sale_unit_price', 'print_price', 'p1_unit_type_id', 'p1_quantity_unit', 'p1_price1', 'p1_price2', 'p1_price3', 'p1_price_default', 'p2_unit_type_id', 'p2_quantity_unit', 'p2_price1', 'p2_price2', 'p2_price3', 'p2_price_default', 'p3_unit_type_id', 'p3_quantity_unit', 'p3_price1', 'p3_price2', 'p3_price3', 'p3_price_default'];
}
