<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialNetwork extends Model
{
    protected $table = 'social_network';
    protected $fillable = ['coffeeshop_id', 'platform', 'link'];

    public function coffeeshop()
    {
        return $this->belongsTo(Coffeeshop::class, 'coffeeshop_id');
    }
}
