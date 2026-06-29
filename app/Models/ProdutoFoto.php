<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoFoto extends Model
{
    protected $table = 'produto_fotos';
    protected $fillable = ['produto_id', 'arquivo'];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}