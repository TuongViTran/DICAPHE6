<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    // Mối quan hệ với Coffeeshop
    public function coffeeshops()
    {
        return $this->hasMany(Coffeeshop::class);
    }
}
   
