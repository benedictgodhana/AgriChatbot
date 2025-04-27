<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'message_limit',
        'has_file_upload',
        'has_voice_input',
        'has_advanced_features',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_subscriptions')
            ->withPivot('starts_at', 'ends_at', 'is_active', 'payment_id')
            ->withTimestamps();
    }
}
