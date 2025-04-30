<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'manufacturer_id',
        'stock_quantity',


    ];


    /**
     * Get the manufacturer that owns the product.
     */

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
    /**
     * Get the category that owns the product.
     */

}
