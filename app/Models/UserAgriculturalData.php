<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAgriculturalData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'farm_name',
        'farm_size',
        'farm_size_unit',
        'location',
        'climate_zone',
        'soil_type',
        'current_crops',
        'farming_methods',
    ];

    protected $casts = [
        'current_crops' => 'array',
        'farming_methods' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
