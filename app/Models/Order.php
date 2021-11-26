<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'sheetId',
        'product_id',
        'inventory_id',
        'street_address',
        'apartment',
        'city',
        'state',
        'country_code',
        'zip',
        'email',
        'name',
        'order_status',
        'payment_ref',
        'transaction_id',
        'payment_amt_cents',
        'ship_charged_cents',
        'ship_cost_cents',
        'subtotal_cents',
        'total_cents',
        'shipper_name',
        'payment_date',
        'shipped_date',
        'tracking_number',
        'tax_total_cents',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'payment_date' => 'datetime',
        'shipped_date' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function scopeSearch($query, string $terms = null)
    {
        collect(explode(' ', $terms))->filter()->each(function ($term) use ($query){

            $term = "%".$term."%";
            $query->where(function($query) use ($term){
                $query->where('products.name', 'like', $term)
                ->orWhereHas('inventory', function($query) use ($term){
                    $query->where('sku', 'like', $term);
                });
            });


        });
    }
}
