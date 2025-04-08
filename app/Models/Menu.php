<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['item_name', 'description', 'price', 'image_url', 'shop_id', 'status'];

    public function coffeeShop()
    {
        return $this->belongsTo(CoffeeShop::class, 'shop_id', 'id');
    }
}
