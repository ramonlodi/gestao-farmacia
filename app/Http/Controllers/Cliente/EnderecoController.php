<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use App\Models\Cidade;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index()
    {
        $enderecos = auth()->user()->enderecos()->with('cidade')->get();
        return view('cliente.enderecos.index', compact('enderecos'));
    }

    public function create()
    {
        $cidades = Cidade::all();
        return view('cliente.enderecos.create', compact('cidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao'  => 'required|string|max:255',
            'cep'        => 'nullable|string|max:9',
            'logradouro' => 'required|string|max:255',
            'numero'     => 'required|string|max:20',
            'bairro'     => 'required|string|max:255',
            'cidade_id'  => 'required|exists:cidades,id',
        ]);

        auth()->user()->enderecos()->create($request->only('descricao', 'cep', 'logradouro', 'numero', 'bairro', 'cidade_id'));
        return redirect()->route('cliente.enderecos.index')->with('success', 'Endereço cadastrado!');
    }

    public function edit(Endereco $endereco)
    {
        if ($endereco->user_id !== auth()->id()) abort(403);
        $cidades = Cidade::all();
        return view('cliente.enderecos.edit', compact('endereco', 'cidades'));
    }

    public function update(Request $request, Endereco $endereco)
    {
        if ($endereco->user_id !== auth()->id()) abort(403);

        $request->validate([
            'descricao'  => 'required|string|max:255',
            'cep'        => 'nullable|string|max:9',
            'logradouro' => 'required|string|max:255',
            'numero'     => 'required|string|max:20',
            'bairro'     => 'required|string|max:255',
            'cidade_id'  => 'required|exists:cidades,id',
        ]);

        $endereco->update($request->only('descricao', 'cep', 'logradouro', 'numero', 'bairro', 'cidade_id'));
        return redirect()->route('cliente.enderecos.index')->with('success', 'Endereço atualizado!');
    }

    public function destroy(Endereco $endereco)
    {
        if ($endereco->user_id !== auth()->id()) abort(403);
        $endereco->delete();
        return redirect()->route('cliente.enderecos.index')->with('success', 'Endereço removido!');
    }
}