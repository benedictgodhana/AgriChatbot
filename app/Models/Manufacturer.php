<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    /**
     * Get the products for the manufacturer.
     */

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the name of the manufacturer.
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
    
}
