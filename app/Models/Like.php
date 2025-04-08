<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'coffee_shop_id'];

    public function coffeeShop()
    {
        return $this->belongsTo(CoffeeShop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
