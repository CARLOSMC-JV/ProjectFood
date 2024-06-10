<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','price','quantity','image','class_categories_id', 'category_id','subcategory_id'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function classCategory()
    {
        return $this->belongsTo(ClassCategory::class, 'class_categories_id', 'id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class, 'class_categories_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    
}
