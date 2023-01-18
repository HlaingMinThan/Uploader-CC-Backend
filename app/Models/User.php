<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function usage()
    {
        return $this->files->sum('size');
    }

    //when user register,default will be free plan
    public function plan()
    {
        return $this->hasOneThrough(Plan::class, Subscription::class, 'user_id', 'stripe_id', 'id', 'stripe_price')
            ->whereNull('subscriptions.ends_at') //when subscription ended, user shouldn't have premium plan exists
            ->withDefault(Plan::free()->toArray());
    }

    public function canDowngrade($plan)
    {
        return $this->usage() <= $plan->storage;
    }
}
