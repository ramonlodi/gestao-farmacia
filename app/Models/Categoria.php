<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {
    protected $fillable = ['nome', 'categoria_pai_id'];

    public function pai() {
        return $this->belongsTo(Categoria::class, 'categoria_pai_id');
    }

    public function filhos() {
        return $this->hasMany(Categoria::class, 'categoria_pai_id');
    }

    public function produtos() {
        return $this->hasMany(Produto::class);
    }

    public function promocoes() {
        return $this->hasMany(Promocao::class);
    }
}