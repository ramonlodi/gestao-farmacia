<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model {
    protected $fillable = ['valor_total', 'user_id', 'endereco_id', 'status_pagamento', 'status_entrega'];
    public function user()     { return $this->belongsTo(User::class); }
    public function endereco() { return $this->belongsTo(Endereco::class); }
    public function produtos() {
        return $this->belongsToMany(Produto::class, 'venda_produto')
                    ->withPivot('quantidade', 'subtotal');
    }
}