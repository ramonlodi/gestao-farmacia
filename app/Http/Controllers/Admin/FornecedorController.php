<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return view('admin.fornecedores.index', compact('fornecedores'));
    }

    public function create()
    {
        return view('admin.fornecedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'cnpj'         => 'required|string|max:18|unique:fornecedores',
            'contato'      => 'nullable|string|max:255',
            'email'        => 'nullable|email',
            'telefone'     => 'nullable|string|max:20',
        ]);

        Fornecedor::create($request->only('razao_social', 'cnpj', 'contato', 'email', 'telefone'));
        return redirect()->route('admin.fornecedores.index')->with('success', 'Fornecedor criado!');
    }

    public function edit(Fornecedor $fornecedor)
    {
        return view('admin.fornecedores.edit', compact('fornecedor'));
    }

    public function update(Request $request, Fornecedor $fornecedor)
    {
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'cnpj'         => 'required|string|max:18|unique:fornecedores,cnpj,' . $fornecedor->id,
            'contato'      => 'nullable|string|max:255',
            'email'        => 'nullable|email',
            'telefone'     => 'nullable|string|max:20',
        ]);

        $fornecedor->update($request->only('razao_social', 'cnpj', 'contato', 'email', 'telefone'));
        return redirect()->route('admin.fornecedores.index')->with('success', 'Fornecedor atualizado!');
    }

    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();
        return redirect()->route('admin.fornecedores.index')->with('success', 'Fornecedor removido!');
    }
}