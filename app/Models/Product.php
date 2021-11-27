<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sheetId',
        'admin_id',
        'name',
        'description',
        'style',
        'brand',
        'type',
        'url',
        'shipping_price',
        'note',
        'created_at',
        'updated_at'
    ];

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
