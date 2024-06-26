<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    //Define los campos que deben desahibilitarse
    protected $guarded = ['id','created_at','updated_at'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    //Relacion uno a muchos inversa
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
