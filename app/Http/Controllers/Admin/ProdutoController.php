<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\ProdutoFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with(['categoria', 'fornecedores', 'fotos'])->get();
        return view('admin.produtos.index', compact('produtos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $fornecedores = Fornecedor::all();
        return view('admin.produtos.create', compact('categorias', 'fornecedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'estoque' => 'required|integer|min:0',
            'valor' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'fornecedores' => 'required|array|min:1',
            'fornecedores.*' => 'exists:fornecedores,id',
            'fotos' => 'nullable|array|max:5',
            'fotos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $slug = Str::slug($request->nome);
        $slugOriginal = $slug;
        $contador = 1;
        while (Produto::where('slug', $slug)->exists()) {
            $slug = $slugOriginal . '-' . $contador++;
        }

        $produto = Produto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'estoque' => $request->estoque,
            'valor' => $request->valor,
            'categoria_id' => $request->categoria_id,
            'slug' => $slug,
        ]);

        $produto->fornecedores()->sync($request->fornecedores);

        if ($request->hasFile('fotos')) {
            if (count($request->file('fotos')) > 5) {
                return back()->with('error', 'Máximo de 5 fotos por produto.');
            }
            foreach ($request->file('fotos') as $foto) {
                $arquivo = $foto->store('produtos', 'public');
                ProdutoFoto::create(['produto_id' => $produto->id, 'arquivo' => $arquivo]);
            }
        }

        return redirect()->route('admin.produtos.index')->with('success', 'Produto criado!');
    }

    public function show(Produto $produto)
    {
        $produto->load(['categoria', 'fornecedores', 'fotos']);
        return view('admin.produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $categorias = Categoria::all();
        $fornecedores = Fornecedor::all();
        $fornecedoresSelecionados = $produto->fornecedores->pluck('id')->toArray();
        return view('admin.produtos.edit', compact('produto', 'categorias', 'fornecedores', 'fornecedoresSelecionados'));
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'estoque' => 'required|integer|min:0',
            'valor' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'fornecedores' => 'required|array|min:1',
            'fornecedores.*' => 'exists:fornecedores,id',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $slug = Str::slug($request->nome);
        $slugOriginal = $slug;
        $contador = 1;
        while (Produto::where('slug', $slug)->where('id', '!=', $produto->id)->exists()) {
            $slug = $slugOriginal . '-' . $contador++;
        }

        $produto->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'estoque' => $request->estoque,
            'valor' => $request->valor,
            'categoria_id' => $request->categoria_id,
            'slug' => $slug,
        ]);

        $produto->fornecedores()->sync($request->fornecedores);

        if ($request->hasFile('fotos')) {
            $totalFotos = $produto->fotos()->count() + count($request->file('fotos'));
            if ($totalFotos > 5) {
                return back()->with('error', 'Limite de 5 fotos por produto atingido.');
            }
            foreach ($request->file('fotos') as $foto) {
                $arquivo = $foto->store('produtos', 'public');
                ProdutoFoto::create(['produto_id' => $produto->id, 'arquivo' => $arquivo]);
            }
        }

        return redirect()->route('admin.produtos.index')->with('success', 'Produto atualizado!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('admin.produtos.index')->with('success', 'Produto removido!');
    }

    public function destroyFoto(ProdutoFoto $foto)
    {
        \Storage::disk('public')->delete($foto->arquivo);
        $foto->delete();
        return back()->with('success', 'Foto removida!');
    }
}