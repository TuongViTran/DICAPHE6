<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [ 'street', 'ward', 'district', 'city','country', 'postal_code'];

    public function coffeeShop()
    {
        return $this->belongsTo(CoffeeShop::class);
    }
}
?>