<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::whereNull('categoria_pai_id')->get();

        $query = Produto::with(['categoria', 'fotos']);

        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }

        if ($request->filled('categoria_id')) {
            $categoriaSelecionada = Categoria::find($request->categoria_id);
            $idsFilhos = $categoriaSelecionada->filhos->pluck('id')->toArray();
            $ids = array_merge([$categoriaSelecionada->id], $idsFilhos);
            $query->whereIn('categoria_id', $ids);
        }

        if ($request->filled('ordem')) {
            if ($request->ordem === 'az') $query->orderBy('nome', 'asc');
            elseif ($request->ordem === 'za') $query->orderBy('nome', 'desc');
            elseif ($request->ordem === 'menor') $query->orderBy('valor', 'asc');
            elseif ($request->ordem === 'maior') $query->orderBy('valor', 'desc');
        }

        $produtos = $query->get();

        $maisVendidos = Produto::with(['fotos', 'categoria'])
            ->withCount('vendas')
            ->orderBy('vendas_count', 'desc')
            ->take(4)
            ->get();

        $categoriasPrincipais = Categoria::whereNull('categoria_pai_id')
            ->with(['filhos', 'produtos' => function($q) {
                $q->with('fotos');
            }])
            ->whereHas('produtos')
            ->orWhereHas('filhos.produtos')
            ->take(4)
            ->get()
            ->map(function($categoria) {
                $produtosFilhos = Produto::with('fotos')
                    ->whereIn('categoria_id', $categoria->filhos->pluck('id')->toArray())
                    ->get();
                $categoria->todosProdutos = $categoria->produtos->merge($produtosFilhos);
                return $categoria;
            });

        $todosProdutos = Produto::with(['fotos', 'categoria'])->orderBy('nome')->get();

        return view('home', compact('produtos', 'categorias', 'maisVendidos', 'categoriasPrincipais', 'todosProdutos'));
    }
    public function show($slug)
    {
        $produto = Produto::with(['categoria', 'fotos', 'fornecedores'])->where('slug', $slug)->firstOrFail();
        return view('produto', compact('produto'));
    }

    public function adminPanel()
    {
        return view('admin.painel');
    }
    public function adminDashboard(Request $request)
    {
        $dataInicio = $request->filled('data_inicio')
            ? \Carbon\Carbon::parse($request->data_inicio)->startOfDay()
            : \Carbon\Carbon::now()->subDays(30)->startOfDay();

        $dataFim = $request->filled('data_fim')
            ? \Carbon\Carbon::parse($request->data_fim)->endOfDay()
            : \Carbon\Carbon::now()->endOfDay();

        $totalVendas = \App\Models\Venda::whereBetween('created_at', [$dataInicio, $dataFim])->count();

        $faturamento = \App\Models\Venda::whereBetween('created_at', [$dataInicio, $dataFim])->sum('valor_total');

        $totalClientes = \App\Models\User::where('role', 'cliente')
            ->whereBetween('created_at', [$dataInicio, $dataFim])->count();

        $estoqueBaixo = \App\Models\Produto::where('estoque', '<', 10)->orderBy('estoque')->get();

        $vendasPorDia = \App\Models\Venda::whereBetween('created_at', [$dataInicio, $dataFim])
            ->selectRaw('DATE(created_at) as dia, COUNT(*) as total, SUM(valor_total) as faturamento')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        $produtosMaisVendidos = \App\Models\Produto::withSum([
            'vendas as quantidade_vendida' => function($q) use ($dataInicio, $dataFim) {
                $q->whereBetween('vendas.created_at', [$dataInicio, $dataFim]);
            }], 'venda_produto.quantidade')
            ->orderByDesc('quantidade_vendida')
            ->take(5)
            ->get();

        $vendasPorCategoria = \App\Models\Categoria::whereNull('categoria_pai_id')
            ->get()
            ->map(function($categoria) use ($dataInicio, $dataFim) {
                $filhosIds = $categoria->filhos->pluck('id')->toArray();
                $ids = array_merge([$categoria->id], $filhosIds);
                $total = \DB::table('venda_produto')
                    ->join('vendas', 'venda_produto.venda_id', '=', 'vendas.id')
                    ->join('produtos', 'venda_produto.produto_id', '=', 'produtos.id')
                    ->whereIn('produtos.categoria_id', $ids)
                    ->whereBetween('vendas.created_at', [$dataInicio, $dataFim])
                    ->sum('venda_produto.quantidade');
                $categoria->total_vendas = $total;
                return $categoria;
            })
            ->filter(fn($c) => $c->total_vendas > 0);

        return view('admin.dashboard', compact(
            'totalVendas', 'faturamento', 'totalClientes', 'estoqueBaixo',
            'vendasPorDia', 'produtosMaisVendidos', 'vendasPorCategoria',
            'dataInicio', 'dataFim'
        ));
    }
}