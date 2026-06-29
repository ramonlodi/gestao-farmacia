<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model {
    protected $fillable = [
        'nome', 'descricao', 'estoque', 'slug', 'valor', 'imagem', 'categoria_id'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function fornecedores() {
        return $this->belongsToMany(Fornecedor::class, 'produto_fornecedor');
    }

    public function vendas() {
        return $this->belongsToMany(Venda::class, 'venda_produto')
                    ->withPivot('quantidade', 'subtotal');
    }

    public function fotos() {
        return $this->hasMany(ProdutoFoto::class);
    }

    public function valorComDesconto() {
        if (!$this->categoria_id) return $this->valor;

        $promo = Promocao::where('categoria_id', $this->categoria_id)
            ->where('data_inicio', '<=', now())
            ->where('data_fim', '>=', now()->startOfDay())
            ->first();

        if (!$promo) return $this->valor;

        if ($promo->tipo_desconto === 'porcentagem') {
            return $this->valor - ($this->valor * $promo->desconto / 100);
        }
        return max(0, $this->valor - $promo->desconto);
    }

    public function temPromocao() {
        if (!$this->categoria_id) return false;
        return Promocao::where('categoria_id', $this->categoria_id)
            ->where('data_inicio', '<=', now())
            ->where('data_fim', '>=', now()->startOfDay())
            ->exists();
    }
}