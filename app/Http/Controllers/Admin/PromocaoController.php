<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocao;
use App\Models\Categoria;
use Illuminate\Http\Request;

class PromocaoController extends Controller
{
    public function index()
    {
        $promocoes = Promocao::with('categoria')->get();
        return view('admin.promocoes.index', compact('promocoes'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.promocoes.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'desconto' => 'required|numeric|min:0',
            'tipo_desconto' => 'required|in:porcentagem,absoluto',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        Promocao::create($request->only('categoria_id', 'desconto', 'tipo_desconto', 'data_inicio', 'data_fim'));
        return redirect()->route('admin.promocoes.index')->with('success', 'Promoção criada!');
    }

    public function edit(Promocao $promocao)
    {
        $categorias = Categoria::all();
        return view('admin.promocoes.edit', compact('promocao', 'categorias'));
    }

    public function update(Request $request, Promocao $promocao)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'desconto' => 'required|numeric|min:0',
            'tipo_desconto' => 'required|in:porcentagem,absoluto',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $promocao->update($request->only('categoria_id', 'desconto', 'tipo_desconto', 'data_inicio', 'data_fim'));
        return redirect()->route('admin.promocoes.index')->with('success', 'Promoção atualizada!');
    }

    public function destroy(Promocao $promocao)
    {
        $promocao->delete();
        return redirect()->route('admin.promocoes.index')->with('success', 'Promoção removida!');
    }
}