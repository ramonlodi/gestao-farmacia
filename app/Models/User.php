<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'nome', 'cpf', 'rg', 'data_nascimento',
        'telefone', 'email', 'password', 'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function enderecos() {
        return $this->hasMany(Endereco::class);
    }

    public function vendas() {
        return $this->hasMany(Venda::class);
    }
}