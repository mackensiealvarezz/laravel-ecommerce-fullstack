<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'sheetId',
        'name',
        'email',
        'password',
        'shop_name',
        'shop_domain',
        'card_brand',
        'card_last_four',
        'billing_plan',
        'trial_ends_at',
        'trial_starts_at',
        'superadmin',
        'is_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'sheetId',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'trial_starts_at' => 'datetime',
        'trial_ends_at' => 'datetime',
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'admin_id');
    }

    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            Product::class,
            'admin_id',
            'product_id',
            'id',
            'id'
        );
    }


}
