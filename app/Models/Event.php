<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event'; 
    
    // Các trường có thể điền
    protected $fillable = ['name', 'date', 'location'];

    // Quan hệ với Coffeeshop (nếu có)
    public function coffeeshop()
    {
        return $this->belongsTo(Coffeeshop::class);
    }

    // Nếu bảng không có created_at và updated_at
    public $timestamps = false;
    
    // Các trường cần định dạng
    protected $dates = ['date'];
}
