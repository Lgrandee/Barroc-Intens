<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_company',
        'contact_person',
        'email',
        'phone_number',
        'bkr_number',
        'address',
        'city',
        'zipcode',
        'bkr_status',
    ];

    /**
     * Zet email altijd om naar lowercase voor case-insensitive opslag
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function offertes()
    {
        return $this->hasMany(Offerte::class, 'name_company_id');
    }

    public function facturen()
    {
        return $this->hasMany(Factuur::class, 'name_company_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'name_company_id');
    }
}
