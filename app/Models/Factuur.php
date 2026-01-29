<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factuur extends Model
{
    use HasFactory;

    protected $table = 'facturen';

    protected $fillable = [
        'name_company_id',
        'offerte_id',
        'invoice_date',
        'due_date',
        'reference',
        'payment_method',
        'description',
        'notes',
        'status',
        'sent_at',
        'paid_at',
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
        'sent_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'name_company_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'factuur_products')
                    ->withTimestamps();
    }

    public function offerte()
    {
        return $this->belongsTo(Offerte::class);
    }

    public function getTotalAmountAttribute()
    {
        return $this->products->sum(function ($product) {
            $qty = $product->pivot->quantity ?? 1;
            return $product->price * $qty;
        });
    }
}
