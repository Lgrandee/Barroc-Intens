<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;

class Offerte extends Model
{
    use HasFactory;

    protected $table = 'offertes';

    protected $fillable = [
        'name_company_id',
        'product_id',
        'status',
        'valid_until',
        'delivery_time_weeks',
        'payment_terms_days',
        'custom_terms',
        'sent_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'name_company_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'offerte_products')->withTimestamps();
    }

    public function factuur()
    {
        return $this->hasOne(Factuur::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
