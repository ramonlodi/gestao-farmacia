@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-bar-chart text-white fs-5"></i>
        </div>
        <div>
            <h3 class="mb-0 fw-700">Dashboard</h3>
            <p class="text-muted small mb-0">{{ $dataInicio->format('d/m/Y') }} até {{ $dataFim->format('d/m/Y') }}</p>
        </div>
    </div>
    <a href="{{ route('admin.dashboard.view') }}" class="btn btn-sm" style="background:#f1f5f9;color:#475569;border-radius:8px;">
        <i class="bi bi-arrow-clockwise me-1"></i>Atualizar
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
    <form method="GET" action="{{ route('admin.dashboard.view') }}">
        <div class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label fw-500 small mb-1">De</label>
                <input type="date" name="data_inicio" class="form-control bg-light border-0" value="{{ $dataInicio->format('Y-m-d') }}">
            </div>
            <div class="col-auto">
                <label class="form-label fw-500 small mb-1">Até</label>
                <input type="date" name="data_fim" class="form-control bg-light border-0" value="{{ $dataFim->format('Y-m-d') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-verde px-4" style="border-radius:10px;">
                    <i class="bi bi-funnel me-1"></i>Filtrar
                </button>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.dashboard.view') }}" class="btn px-4" style="background:#f1f5f9;color:#475569;border-radius:10px;">Limpar</a>
            </div>
            <div class="col-auto ms-2 d-flex gap-2">
                <a href="{{ route('admin.dashboard.view', ['data_inicio' => now()->format('Y-m-d'), 'data_fim' => now()->format('Y-m-d')]) }}"
                   class="btn btn-sm" style="background:#f0fdf4;color:#15803D;border-radius:8px;">Hoje</a>
                <a href="{{ route('admin.dashboard.view', ['data_inicio' => now()->subDays(7)->format('Y-m-d'), 'data_fim' => now()->format('Y-m-d')]) }}"
                   class="btn btn-sm" style="background:#f0fdf4;color:#15803D;border-radius:8px;">7 dias</a>
                <a href="{{ route('admin.dashboard.view', ['data_inicio' => now()->subDays(30)->format('Y-m-d'), 'data_fim' => now()->format('Y-m-d')]) }}"
                   class="btn btn-sm" style="background:#f0fdf4;color:#15803D;border-radius:8px;">30 dias</a>
                <a href="{{ route('admin.dashboard.view', ['data_inicio' => now()->startOfMonth()->format('Y-m-d'), 'data_fim' => now()->format('Y-m-d')]) }}"
                   class="btn btn-sm" style="background:#f0fdf4;color:#15803D;border-radius:8px;">Este mês</a>
            </div>
        </div>
    </form>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left:4px solid #15803D !important;">
            <p class="text-muted small mb-1">Total de Pedidos</p>
            <h3 class="fw-700 mb-0" style="color:#15803D;">{{ $totalVendas }}</h3>
            <p class="text-muted small mt-1 mb-0"><i class="bi bi-bag-check me-1"></i>no período</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left:4px solid #2563EB !important;">
            <p class="text-muted small mb-1">Faturamento</p>
            <h3 class="fw-700 mb-0" style="color:#2563EB;">R$ {{ number_format($faturamento, 2, ',', '.') }}</h3>
            <p class="text-muted small mt-1 mb-0"><i class="bi bi-currency-dollar me-1"></i>no período</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left:4px solid #ca8a04 !important;">
            <p class="text-muted small mb-1">Novos Clientes</p>
            <h3 class="fw-700 mb-0" style="color:#ca8a04;">{{ $totalClientes }}</h3>
            <p class="text-muted small mt-1 mb-0"><i class="bi bi-people me-1"></i>cadastrados</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border-left:4px solid #e11d48 !important;">
            <p class="text-muted small mb-1">Estoque Baixo</p>
            <h3 class="fw-700 mb-0" style="color:#e11d48;">{{ $estoqueBaixo->count() }}</h3>
            <p class="text-muted small mt-1 mb-0"><i class="bi bi-exclamation-triangle me-1"></i>produtos</p>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-700 mb-0">Faturamento e Pedidos por Dia</h6>
        <span class="badge" style="background:#f0fdf4;color:#15803D;">{{ $vendasPorDia->count() }} dias com vendas</span>
    </div>
    @if($vendasPorDia->count() > 0)
        <canvas id="graficoFaturamento" style="max-height:280px;"></canvas>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-graph-up fs-1 mb-3 d-block" style="color:#cbd5e1;"></i>
            Nenhuma venda no período selecionado
        </div>
    @endif
</div>

<div class="row g-4 mb-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h6 class="fw-700 mb-3">Top 5 Produtos Mais Vendidos</h6>
            @if($produtosMaisVendidos->filter(fn($p) => $p->quantidade_vendida > 0)->count() > 0)
                <canvas id="graficoProdutos" style="max-height:250px;"></canvas>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-capsule fs-1 mb-2 d-block" style="color:#cbd5e1;"></i>
                    Nenhuma venda no período
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h6 class="fw-700 mb-3">Vendas por Categoria</h6>
            @if($vendasPorCategoria->count() > 0)
                <div style="max-height:250px;display:flex;align-items:center;justify-content:center;">
                    <canvas id="graficoCategorias"></canvas>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-pie-chart fs-1 mb-2 d-block" style="color:#cbd5e1;"></i>
                    Nenhuma venda no período
                </div>
            @endif
        </div>
    </div>
</div>

@if($estoqueBaixo->count() > 0)
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
    <h6 class="fw-700 mb-3"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Produtos com Estoque Baixo</h6>
    <div class="row g-2">
        @foreach($estoqueBaixo as $produto)
        <div class="col-md-4">
            <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background:#fff8f8;">
                <div>
                    <p class="fw-600 small mb-0">{{ Str::limit($produto->nome, 30) }}</p>
                    <p class="text-muted mb-0" style="font-size:0.75rem;">{{ $produto->categoria->nome ?? '—' }}</p>
                </div>
                <span class="badge" style="{{ $produto->estoque == 0 ? 'background:#e11d48;' : 'background:#fff1f2;color:#e11d48;' }}">
                    {{ $produto->estoque == 0 ? 'Esgotado' : $produto->estoque . ' un.' }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($vendasPorDia->count() > 0)
    var dias = {{ $vendasPorDia->count() }};
    new Chart(document.getElementById('graficoFaturamento'), {
        type: dias <= 1 ? 'bar' : 'line',
        data: {
            labels: @json($vendasPorDia->pluck('dia')),
            datasets: [
                {
                    label: 'Faturamento (R$)',
                    data: @json($vendasPorDia->pluck('faturamento')),
                    borderColor: '#15803D',
                    backgroundColor: dias <= 1 ? 'rgba(21,128,61,0.8)' : 'rgba(21,128,61,0.08)',
                    fill: dias > 1,
                    tension: 0.4,
                    pointRadius: dias <= 7 ? 5 : 3,
                    pointBackgroundColor: '#15803D',
                    borderRadius: 8,
                    yAxisID: 'y',
                },
                {
                    label: 'Pedidos',
                    data: @json($vendasPorDia->pluck('total')),
                    borderColor: '#2563EB',
                    backgroundColor: dias <= 1 ? 'rgba(37,99,235,0.8)' : 'rgba(37,99,235,0.08)',
                    fill: false,
                    tension: 0.4,
                    pointRadius: dias <= 7 ? 5 : 3,
                    pointBackgroundColor: '#2563EB',
                    borderRadius: 8,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: {
                y: {
                    position: 'left',
                    ticks: { callback: v => 'R$ ' + Number(v).toLocaleString('pt-BR') }
                },
                y1: {
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
@endif

@if($produtosMaisVendidos->filter(fn($p) => $p->quantidade_vendida > 0)->count() > 0)
    new Chart(document.getElementById('graficoProdutos'), {
        type: 'bar',
        data: {
            labels: @json($produtosMaisVendidos->map(fn($p) => \Illuminate\Support\Str::limit($p->nome, 25))->values()),
            datasets: [{
                label: 'Unidades vendidas',
                data: @json($produtosMaisVendidos->pluck('quantidade_vendida')->values()),
                backgroundColor: [
                    'rgba(21,128,61,0.8)',
                    'rgba(37,99,235,0.8)',
                    'rgba(202,138,4,0.8)',
                    'rgba(225,29,72,0.8)',
                    'rgba(2,132,199,0.8)',
                ],
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { font: { size: 11 } } }
            }
        }
    });
@endif

@if($vendasPorCategoria->count() > 0)
    new Chart(document.getElementById('graficoCategorias'), {
        type: 'doughnut',
        data: {
            labels: @json($vendasPorCategoria->pluck('nome')->values()),
            datasets: [{
                data: @json($vendasPorCategoria->pluck('total_vendas')->values()),
                backgroundColor: ['#15803D','#2563EB','#ca8a04','#e11d48','#0284c7','#7c3aed'],
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 12 } }
            }
        }
    });
@endif
</script>
@endsection