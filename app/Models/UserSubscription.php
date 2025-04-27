<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subscription_id',
        'status',
        'start_date',
        'end_date',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    public function isActive()
    {
        return $this->status === 'active' && $this->end_date > now();
    }
    public function isExpired()
    {
        return $this->status === 'active' && $this->end_date <= now();
    }
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
    public function isPending()
    {
        return $this->status === 'pending';
    }
    public function isTrial()
    {
        return $this->status === 'trial';
    }
    public function isFree()
    {
        return $this->status === 'free';
        
    }
    public function isFreeTrial()
    {
        return $this->status === 'free_trial';
    }
    public function isPaid()
    {
        return $this->status === 'paid';
    }
    public function isFreePlan()
    {
        return $this->status === 'free_plan';
    }
    public function isPaidPlan()
    {
        return $this->status === 'paid_plan';
    }
    public function isTrialPlan()
    {
        return $this->status === 'trial_plan';
    }
    public function isFreeTrialPlan()
    {
        return $this->status === 'free_trial_plan';
    }
    public function isPaidTrialPlan()
    {
        return $this->status === 'paid_trial_plan';
    }

}
