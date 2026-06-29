<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function index()
    {
        $cidades = Cidade::all();
        return view('admin.cidades.index', compact('cidades'));
    }

    public function create()
    {
        return view('admin.cidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:cidades,nome,NULL,id,estado,' . $request->estado,
            'estado' => 'required|string|max:2',
        ]);

        Cidade::create($request->only('nome', 'estado'));
        return redirect()->route('admin.cidades.index')->with('success', 'Cidade criada!');
    }

    public function edit(Cidade $cidade)
    {
        return view('admin.cidades.edit', compact('cidade'));
    }

    public function update(Request $request, Cidade $cidade)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:cidades,nome,' . $cidade->id . ',id,estado,' . $request->estado,
            'estado' => 'required|string|max:2',
        ]);

        $cidade->update($request->only('nome', 'estado'));
        return redirect()->route('admin.cidades.index')->with('success', 'Cidade atualizada!');
    }

    public function destroy(Cidade $cidade)
    {
        $cidade->delete();
        return redirect()->route('admin.cidades.index')->with('success', 'Cidade removida!');
    }
}