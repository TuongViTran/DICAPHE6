<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentSearch extends Model
{
    protected $table = 'recentsearches';

    protected $fillable = [
        'user_id',
        'keyword',
        'style_id',
        'min_price',
        'max_price',
        'latitude',
        'longitude',
        'distance',
        'result_count',
    ];

    // Quan hệ nếu cần
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }
}
