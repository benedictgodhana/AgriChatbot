<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'user_subscriptions')
            ->withPivot('starts_at', 'ends_at', 'is_active', 'payment_id')
            ->withTimestamps();
    }

    public function activeSubscription()
    {
        return $this->subscriptions()
            ->wherePivot('is_active', true)
            ->wherePivot('ends_at', '>', now())
            ->orderByPivot('ends_at', 'desc')
            ->first();
    }

    public function agricultureData()
    {
        return $this->hasOne(UserAgriculturalData::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function userSubscription()
    {
        return $this->hasMany(UserSubscription::class);
    }
    public function userAgriculturalData()
    {
        return $this->hasMany(UserAgriculturalData::class);
    }

}