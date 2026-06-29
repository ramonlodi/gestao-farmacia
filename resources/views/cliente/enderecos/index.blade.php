@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-geo-alt text-white fs-5"></i>
        </div>
        <div>
            <h3 class="mb-0 fw-700">Meus Endereços</h3>
            <p class="text-muted small mb-0">Gerencie seus endereços de entrega</p>
        </div>
    </div>
    <a href="{{ route('cliente.enderecos.create') }}" class="btn btn-verde px-4" style="border-radius:10px;">
        <i class="bi bi-plus-circle me-2"></i>Novo Endereço
    </a>
</div>

@forelse($enderecos as $endereco)
<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="fw-700 mb-1">{{ $endereco->descricao }}</h6>
                <p class="text-muted mb-1 small">{{ $endereco->logradouro }}, {{ $endereco->numero }} — {{ $endereco->bairro }}</p>
                <p class="text-muted mb-0 small"><i class="bi bi-geo-alt me-1"></i>{{ $endereco->cidade->nome ?? '—' }} / {{ $endereco->cidade->estado ?? '' }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('cliente.enderecos.edit', $endereco) }}" class="btn btn-sm" style="background:#f0fdf4;color:#15803D;border-radius:8px;">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('cliente.enderecos.destroy', $endereco) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm" style="background:#fff1f2;color:#e11d48;border-radius:8px;" onclick="return confirm('Confirmar exclusão?')">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@empty
<div class="card border-0 shadow-sm rounded-4 p-5 text-center">
    <i class="bi bi-geo" style="font-size:4rem;color:#cbd5e1;"></i>
    <h5 class="mt-3 text-muted">Nenhum endereço cadastrado</h5>
    <a href="{{ route('cliente.enderecos.create') }}" class="btn btn-verde mt-3 px-4" style="border-radius:10px;">
        <i class="bi bi-plus-circle me-2"></i>Adicionar endereço
    </a>
</div>
@endforelse
@endsection