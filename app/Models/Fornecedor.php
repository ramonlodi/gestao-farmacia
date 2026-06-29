<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model {
    protected $table = 'fornecedores';
    protected $fillable = ['razao_social', 'cnpj', 'contato', 'email', 'telefone'];

    public function produtos() {
        return $this->belongsToMany(Produto::class, 'produto_fornecedor');
    }
}