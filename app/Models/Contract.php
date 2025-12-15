<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_company_id',
        'product_id',
        'offerte_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'name_company_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function offerte()
    {
        return $this->belongsTo(Offerte::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'contract_product');
    }
}
