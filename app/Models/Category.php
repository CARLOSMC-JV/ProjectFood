<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','class_category_id'];

    //Relacion de uno a muchos
    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }

    //Relacion muchos a muchos
    public function brands(){
        return $this->belongsToMany(Brand::class);
    }

    public function products(){
        return $this->hasManyThrough(Product::class, Subcategory::class);
    }

    //Relacion uno a muchos inversa
    public function ClassCategory(){
        return $this->belongsTo(Classcategory::class);
    }
}
