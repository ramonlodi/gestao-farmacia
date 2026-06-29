@extends('layouts.app')

@section('content')

@guest
<div class="rounded-4 mb-5 overflow-hidden" style="background:linear-gradient(135deg,#15803D 0%,#1a4a7a 100%);min-height:280px;position:relative;">
    <div class="row align-items-center h-100 p-4 p-md-5">
        <div class="col-md-7">
            <span class="badge mb-3" style="background:rgba(255,255,255,0.2);color:white;font-size:0.8rem;padding:6px 14px;">
                <i class="bi bi-shield-check me-1"></i> Farmácia online de confiança
            </span>
            <h1 style="color:white;font-weight:800;font-size:2.2rem;line-height:1.2;" class="mb-3">
                Saúde e bem-estar<br>na palma da sua mão
            </h1>
            <p style="color:rgba(255,255,255,0.85);font-size:1rem;" class="mb-4">
                Medicamentos, perfumaria e muito mais. Entregamos em Caçador e região.
            </p>
            <div class="d-flex gap-3">
                <a href="{{ route('registro') }}" class="btn btn-light fw-600 px-4" style="border-radius:10px;">
                    <i class="bi bi-person-plus me-2"></i>Cadastre-se grátis
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light px-4" style="border-radius:10px;">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                </a>
            </div>
        </div>
        <div class="col-md-5 text-center d-none d-md-block">
            <i class="bi bi-plus-circle" style="font-size:8rem;color:rgba(255,255,255,0.15);"></i>
        </div>
    </div>
</div>
@endguest

{{-- BUSCA --}}
<div class="card border-0 shadow-sm rounded-4 mb-5 p-3" style="background:white;">
    <form method="GET" action="{{ route('home') }}">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text border-0 bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="busca" class="form-control border-0 bg-light" placeholder="Buscar medicamentos, perfumaria..." value="{{ request('busca') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="categoria_id" class="form-select border-0 bg-light">
                    <option value="">Todas as categorias</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="ordem" class="form-select border-0 bg-light">
                    <option value="">Ordenar</option>
                    <option value="az" {{ request('ordem') == 'az' ? 'selected' : '' }}>A → Z</option>
                    <option value="za" {{ request('ordem') == 'za' ? 'selected' : '' }}>Z → A</option>
                    <option value="menor" {{ request('ordem') == 'menor' ? 'selected' : '' }}>Menor preço</option>
                    <option value="maior" {{ request('ordem') == 'maior' ? 'selected' : '' }}>Maior preço</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-verde w-100">
                    <i class="bi bi-search me-1"></i>Buscar
                </button>
            </div>
        </div>
    </form>
</div>

@if(request('busca') || request('categoria_id') || request('ordem'))

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="section-title mb-0"><i class="bi bi-search"></i> Resultados</h4>
    <a href="{{ route('home') }}" class="btn btn-sm" style="background:#f1f5f9;color:#475569;border-radius:8px;">
        <i class="bi bi-x me-1"></i>Limpar filtros
    </a>
</div>

<div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
    @forelse($produtos as $produto)
        @include('partials.card-produto', ['produto' => $produto])
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                <i class="bi bi-search" style="font-size:3rem;color:#cbd5e1;"></i>
                <h5 class="mt-3 text-muted">Nenhum produto encontrado</h5>
                <a href="{{ route('home') }}" class="btn btn-verde mt-3 px-4" style="border-radius:10px;">Ver todos</a>
            </div>
        </div>
    @endforelse
</div>

@else

{{-- MAIS VENDIDOS --}}
@if($maisVendidos->count() > 0)
<h4 class="section-title"><i class="bi bi-fire text-danger"></i> Mais Vendidos</h4>
<div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
    @foreach($maisVendidos as $produto)
        @include('partials.card-produto', ['produto' => $produto])
    @endforeach
</div>
@endif

{{-- SEÇÕES POR CATEGORIA PRINCIPAL COM SCROLL --}}
@foreach($categoriasPrincipais as $categoria)
@if($categoria->todosProdutos->count() > 0)
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="section-title mb-0"><i class="bi bi-tag"></i> {{ $categoria->nome }}</h4>
    <small class="text-muted">{{ $categoria->todosProdutos->count() }} produtos</small>
</div>
<div class="mb-5">
    <div class="d-flex gap-3 pb-3" style="overflow-x:auto;scrollbar-width:thin;">
        @foreach($categoria->todosProdutos as $produto)
        <div style="min-width:220px;max-width:220px;">
            @include('partials.card-produto', ['produto' => $produto])
        </div>
        @endforeach
    </div>
</div>
@endif
@endforeach

{{-- TODOS OS PRODUTOS --}}
<h4 class="section-title"><i class="bi bi-grid"></i> Todos os Produtos</h4>
<div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
    @forelse($todosProdutos as $produto)
        @include('partials.card-produto', ['produto' => $produto])
    @empty
        <div class="col-12"><p class="text-muted">Nenhum produto cadastrado ainda.</p></div>
    @endforelse
</div>

@endif

@endsection