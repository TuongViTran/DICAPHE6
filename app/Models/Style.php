<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    use HasFactory;

    protected $fillable = ['style_name', 'description'];

    public function coffeeshops()
    {
        return $this->hasMany(Coffeeshop::class, 'styles_id'); // Liên kết với model Coffeeshop
    }
}