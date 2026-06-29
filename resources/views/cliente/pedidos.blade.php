@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <div style="width:48px;height:48px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:14px;display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-bag text-white fs-5"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-700">Meus Pedidos</h3>
        <p class="text-muted small mb-0">Acompanhe seus pedidos em tempo real</p>
    </div>
</div>

@forelse($vendas as $venda)
@php
    $statusPag = $venda->status_pagamento ?? 'pendente';
    $corPag = match(strtolower($statusPag)) {
        'aprovado' => ['bg' => '#f0fdf4', 'color' => '#15803D', 'icon' => 'bi-check-circle-fill'],
        'negado', 'recusado' => ['bg' => '#fff1f2', 'color' => '#e11d48', 'icon' => 'bi-x-circle-fill'],
        default => ['bg' => '#fefce8', 'color' => '#ca8a04', 'icon' => 'bi-clock-fill'],
    };
    $statusEntrega = $venda->status_entrega ?? 'Pendente';
    $etapas = [
        'Pendente' => ['icon' => 'bi-clock',      'label' => 'Pedido recebido'],
        'Saiu para entrega' => ['icon' => 'bi-bicycle',    'label' => 'Saiu para entrega'],
        'Em Trânsito' => ['icon' => 'bi-truck',      'label' => 'Em trânsito'],
        'Entregue' => ['icon' => 'bi-house-check','label' => 'Entregue'],
    ];
    $ordem = array_keys($etapas);
    $indexAtual = array_search($statusEntrega, $ordem);
    if ($indexAtual === false) $indexAtual = 0;
    $totalEtapas = count($etapas);
@endphp

<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

    {{-- HEADER --}}
    <div class="card-header border-0 py-3 px-4 d-flex justify-content-between align-items-center" style="background:#f8fafc;">
        <div class="d-flex align-items-center gap-3">
            <div>
                <span class="fw-700">Pedido #{{ $venda->id }}</span>
                <span class="text-muted small ms-2">{{ $venda->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <span class="badge d-flex align-items-center gap-1" style="background:{{ $corPag['bg'] }};color:{{ $corPag['color'] }};padding:6px 10px;border-radius:8px;">
                <i class="bi {{ $corPag['icon'] }}"></i> {{ ucfirst($statusPag) }}
            </span>
        </div>
        <span class="fw-700" style="color:#15803D;font-size:1.1rem;">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</span>
    </div>

    {{-- BODY --}}
    <div class="card-body px-4 py-4">

        {{-- TIMELINE --}}
        <p class="small fw-600 text-muted mb-3">STATUS DA ENTREGA</p>
        <div class="position-relative mb-4" style="padding:0 18px;">
            <div style="position:absolute;top:18px;left:18px;right:18px;height:2px;background:#e2e8f0;z-index:0;"></div>
            @if($indexAtual > 0)
            <div style="position:absolute;top:18px;left:18px;width:calc({{ ($indexAtual / ($totalEtapas - 1)) * 100 }}% - 0px);height:2px;background:#15803D;z-index:1;"></div>
            @endif
            <div class="d-flex justify-content-between position-relative" style="z-index:2;">
                @foreach($etapas as $key => $etapa)
                @php
                    $i = array_search($key, $ordem);
                    $concluido = $i <= $indexAtual;
                    $atual = $i === $indexAtual;
                @endphp
                <div class="d-flex flex-column align-items-center" style="width:{{ 100 / $totalEtapas }}%;">
                    <div style="width:36px;height:36px;border-radius:50%;background:{{ $atual ? '#15803D' : ($concluido ? '#dcfce7' : '#f8fafc') }};border:2px solid {{ $concluido ? '#15803D' : '#e2e8f0' }};display:flex;align-items:center;justify-content:center;">
                        <i class="bi {{ $etapa['icon'] }}" style="color:{{ $atual ? 'white' : ($concluido ? '#15803D' : '#94a3b8') }};font-size:0.85rem;"></i>
                    </div>
                    <span class="mt-2 text-center" style="font-size:0.65rem;color:{{ $atual ? '#15803D' : '#94a3b8' }};font-weight:{{ $atual ? '700' : '400' }};line-height:1.3;max-width:65px;">
                        {{ $etapa['label'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- STATUS DESCONHECIDO --}}
        @if(!in_array($statusEntrega, $ordem))
        <div class="mb-3 p-2 rounded-3 d-inline-block" style="background:#fff1f2;">
            <span class="small" style="color:#e11d48;"><i class="bi bi-info-circle me-1"></i>{{ $statusEntrega }}</span>
        </div>
        @endif

        {{-- PRODUTOS --}}
        <div class="mb-3">
            @foreach($venda->produtos as $produto)
            <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:#f1f5f9 !important;">
                <span class="small">{{ $produto->nome }}
                    <span class="badge" style="background:#f1f5f9;color:#475569;">x{{ $produto->pivot->quantidade }}</span>
                </span>
                <span class="small fw-600">R$ {{ number_format($produto->pivot->subtotal, 2, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        {{-- ENDEREÇO --}}
        @if($venda->endereco)
        <div class="d-flex align-items-start gap-2 p-3 rounded-3" style="background:#f8fafc;">
            <i class="bi bi-geo-alt text-muted mt-1"></i>
            <div>
                <p class="small fw-600 mb-0">Endereço de entrega</p>
                <p class="small text-muted mb-0">
                    {{ $venda->endereco->logradouro }}, {{ $venda->endereco->numero }},
                    {{ $venda->endereco->bairro }} —
                    {{ $venda->endereco->cidade->nome ?? '' }}/{{ $venda->endereco->cidade->estado ?? '' }}
                </p>
            </div>
        </div>
        @endif

    </div>
</div>
@empty
<div class="card border-0 shadow-sm rounded-4 p-5 text-center">
    <i class="bi bi-bag-x" style="font-size:4rem;color:#cbd5e1;"></i>
    <h5 class="mt-3 text-muted">Nenhum pedido realizado ainda</h5>
    <a href="{{ route('home') }}" class="btn btn-verde mt-3 px-4" style="border-radius:10px;">
        <i class="bi bi-arrow-left me-2"></i>Ver produtos
    </a>
</div>
@endforelse
@endsection