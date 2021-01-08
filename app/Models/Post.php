<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public function categoria()
    {
        return $this->belongsTo(Categoria::class,'categoria_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function imagenes()
    {
        return $this->hasMany(Imagen::class,'post_id');
    }
}
