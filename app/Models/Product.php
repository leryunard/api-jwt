<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // php artisan make:model Product
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'description', 'category_id'];

    // definición de la relación muchos a uno
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
