@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <div style="width:48px;height:48px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:14px;display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-bag-check text-white fs-5"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-700">Finalizar Compra</h3>
        <p class="text-muted small mb-0">Confirme seu endereço e finalize o pedido</p>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <form method="POST" action="{{ route('cliente.venda.store') }}">
            @csrf
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-3">
                <h6 class="fw-700 mb-3"><i class="bi bi-geo-alt me-2" style="color:#15803D;"></i>Endereço de entrega</h6>
                @foreach($enderecos as $endereco)
                <div class="form-check mb-2 p-3 rounded-3" style="background:#f8fafc;margin-left:0;">
                    <input class="form-check-input" type="radio" name="endereco_id" value="{{ $endereco->id }}" id="end{{ $endereco->id }}" required>
                    <label class="form-check-label ms-2" for="end{{ $endereco->id }}">
                        <span class="fw-600">{{ $endereco->descricao }}</span>
                        <span class="text-muted"> — {{ $endereco->logradouro }}, {{ $endereco->numero }}, {{ $endereco->bairro }}, {{ $endereco->cidade->nome ?? '' }}</span>
                    </label>
                </div>
                @endforeach
                <a href="{{ route('cliente.enderecos.create') }}" class="btn btn-sm mt-2" style="background:#f0fdf4;color:#15803D;border-radius:8px;">
                    <i class="bi bi-plus-circle me-1"></i>Novo endereço
                </a>
            </div>
            <button type="submit" class="btn btn-verde w-100 py-3 fw-600" style="border-radius:12px;font-size:1.1rem;">
                <i class="bi bi-lock me-2"></i>Confirmar Pedido
            </button>
        </form>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-700 mb-3">Resumo do pedido</h6>
            @foreach($carrinho as $item)
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">{{ $item['nome'] }} <span class="badge bg-light text-muted">x{{ $item['quantidade'] }}</span></span>
                <span class="fw-600">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</span>
            </div>
            @endforeach
            <hr>
            <div class="d-flex justify-content-between fw-700">
                <span>Total</span>
                <span style="color:#15803D;font-size:1.2rem;">R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection