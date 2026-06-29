<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with('pai')->get();
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        $categorias = Categoria::all(); // para escolher categoria pai
        return view('admin.categorias.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria_pai_id' => 'nullable|exists:categorias,id',
        ]);

        Categoria::create($request->only('nome', 'categoria_pai_id'));
        return redirect()->route('admin.categorias.index')->with('success', 'Categoria criada!');
    }

    public function edit(Categoria $categoria)
    {
        $categorias = Categoria::where('id', '!=', $categoria->id)->get();
        return view('admin.categorias.edit', compact('categoria', 'categorias'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria_pai_id' => 'nullable|exists:categorias,id',
        ]);

        $categoria->update($request->only('nome', 'categoria_pai_id'));
        return redirect()->route('admin.categorias.index')->with('success', 'Categoria atualizada!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('success', 'Categoria removida!');
    }
}