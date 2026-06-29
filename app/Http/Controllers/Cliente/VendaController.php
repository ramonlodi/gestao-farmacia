<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VendaController extends Controller
{
    public function carrinho()
    {
        $carrinho = session()->get('carrinho', []);
        $total = array_sum(array_map(fn($item) => $item['subtotal'], $carrinho));
        return view('cliente.carrinho', compact('carrinho', 'total'));
    }

    public function adicionar(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = Produto::findOrFail($request->produto_id);

        if ($produto->estoque < $request->quantidade) {
            return back()->with('error', 'Quantidade indisponível em estoque.');
        }

        $carrinho = session()->get('carrinho', []);
        $id = $produto->id;

        if (isset($carrinho[$id])) {
            $novaQtd = $carrinho[$id]['quantidade'] + $request->quantidade;
            if ($produto->estoque < $novaQtd) {
                return back()->with('error', 'Quantidade indisponível em estoque.');
            }
            $carrinho[$id]['quantidade'] = $novaQtd;
            $carrinho[$id]['subtotal'] = $novaQtd * $carrinho[$id]['preco'];
        } else {
            $preco = $produto->valorComDesconto();
            $carrinho[$id] = [
                'produto_id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $preco,
                'quantidade' => $request->quantidade,
                'subtotal' => $preco * $request->quantidade,
            ];
        }

        session()->put('carrinho', $carrinho);
        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function remover(Request $request)
    {
        $carrinho = session()->get('carrinho', []);
        unset($carrinho[$request->produto_id]);
        session()->put('carrinho', $carrinho);
        return back()->with('success', 'Produto removido.');
    }

    public function finalizar()
    {
        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('home')->with('error', 'Seu carrinho está vazio.');
        }

        $enderecos = auth()->user()->enderecos()->with('cidade')->get();

        if ($enderecos->isEmpty()) {
            return redirect()->route('cliente.enderecos.create')->with('error', 'Cadastre um endereço antes de finalizar a compra.');
        }

        $total = array_sum(array_map(fn($item) => $item['subtotal'], $carrinho));
        return view('cliente.finalizar', compact('carrinho', 'total', 'enderecos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'endereco_id' => 'required|exists:enderecos,id',
        ]);

        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('home')->with('error', 'Carrinho vazio.');
        }

        $endereco = Endereco::where('id', $request->endereco_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $total = array_sum(array_map(fn($item) => $item['subtotal'], $carrinho));
        $user = auth()->user();

        try {
            $response = Http::post(rtrim(config('cacapay.url'), '/') . '/api/compras', [
                'cpf' => $user->cpf,
                'token' => config('cacapay.token'),
                'valor' => $total,
                'nome' => $user->nome,
                'email' => $user->email,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Não foi possível conectar ao sistema de pagamento.');
        }

        if ($response->failed()) {
            $mensagem = $response->json('message') ?? 'Pagamento não autorizado.';
            return back()->with('error', $mensagem);
        }

        $venda = Venda::create([
            'user_id' => $user->id,
            'endereco_id' => $endereco->id,
            'valor_total' => $total,
            'status_pagamento' => 'aprovado',
            'status_entrega' => 'Pendente',
        ]);

        foreach ($carrinho as $item) {
            $produto = Produto::findOrFail($item['produto_id']);
            $venda->produtos()->attach($produto->id, [
                'quantidade' => $item['quantidade'],
                'subtotal' => $item['subtotal'],
            ]);
            $produto->decrement('estoque', $item['quantidade']);
        }

        try {
            $conteudo = array_values(array_map(fn($item) => [
                'nome' => $item['nome'],
                'quantidade' => $item['quantidade'],
            ], $carrinho));

            $respostaCacalog = Http::timeout(10)->post(rtrim(env('CACALOG_URL'), '/') . '/api/entregas', [
                'token' => env('CACALOG_TOKEN'),
                'codigo_pedido' => (string) $venda->id,
                'cep' => $endereco->cep,
                'logradouro' => $endereco->logradouro,
                'numero' => $endereco->numero,
                'complemento' => '',
                'bairro' => $endereco->bairro,
                'nome_destinatario' => $user->nome,
                'conteudo' => $conteudo,
            ]);

            \Illuminate\Support\Facades\Log::info('CaçaLog resposta', [
                'status' => $respostaCacalog->status(),
                'body' => $respostaCacalog->body(),
            ]);

            if ($respostaCacalog->successful()) {
                \Illuminate\Support\Facades\Log::info('Entrega registrada no CaçaLog com sucesso', [
                    'venda_id' => $venda->id,
                ]);
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('CaçaLog erro: ' . $e->getMessage());
        }

        session()->forget('carrinho');
        return redirect()->route('cliente.pedidos')->with('success', 'Compra finalizada! Acompanhe seu pedido abaixo.');
    }

    public function historico()
    {
        $vendas = auth()->user()->vendas()->with(['produtos', 'endereco.cidade'])->orderBy('created_at', 'desc')->get();
        return view('cliente.pedidos', compact('vendas'));
    }
}