<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // php artisan make:model Category
    use HasFactory;
    protected $table = 'categoria';
    protected $fillable = ['nombre'];
    
    // definición de la relación uno a muchos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
