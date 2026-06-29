<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Promocao extends Model {
    protected $table = 'promocoes';
    protected $primaryKey = 'id';

    public static function boot()
    {
        parent::boot();
    }

    protected $fillable = ['categoria_id', 'desconto', 'tipo_desconto', 'data_inicio', 'data_fim'];
    protected $casts = ['data_inicio' => 'datetime', 'data_fim' => 'datetime'];

    public function categoria() { return $this->belongsTo(Categoria::class); }
}

