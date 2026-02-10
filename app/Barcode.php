<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;
        
    protected $fillable = ['item_id', 'name', 'second_name', 'description', 'unit_type_id', 'model', 'factory_code', 'barcode', 'technical_specifications', 'item_type_id', 'internal_id', 'item_code'];
}
