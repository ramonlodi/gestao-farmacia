<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model {
    protected $fillable = ['descricao', 'cep', 'logradouro', 'numero', 'bairro', 'cidade_id', 'user_id'];
    public function cidade() { return $this->belongsTo(Cidade::class); }
    public function user() { return $this->belongsTo(User::class); }
}