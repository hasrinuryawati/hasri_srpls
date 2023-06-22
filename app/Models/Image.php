<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $primaryKey = 'id';  
    protected $fillable = [
                            'name', 
                            'file',
                            'enable'
    ]; 

    public function product() : BelongsToMany {
        return $this->belongsToMany(Product::class, 'product_images');
      }
}
