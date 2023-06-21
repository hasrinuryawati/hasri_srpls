<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';  
    protected $fillable = [
        'name', 
        'description',
        'enable'
    ]; 
    
    public function category() : BelongsToMany {
        return $this->belongsToMany(Category::class, 'category_products');
    }
}
