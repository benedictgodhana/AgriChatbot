<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'icon',
        'group',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all active menu items by group
     */
    public static function getByGroup($group)
    {
        return self::where('group', $group)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}