<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id', 'gender', 'picture', 'city', 'address','phone_number','preference'
    ];

    protected $with = ['currency'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class, 'preferred_currency_id');
    }
}
