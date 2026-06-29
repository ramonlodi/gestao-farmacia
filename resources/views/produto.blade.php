@extends('layouts.app')

@section('content')
<style>
    .descricao-produto ul {
        list-style-type: disc !important;
        padding-left: 20px;
    }

    .descricao-produto ol {
        list-style-type: disc !important;
        padding-left: 20px;
    }

    .descricao-produto li {
        color: #6b7280;
    }
</style>

<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="row">
        <div class="col-md-6">
            @if($produto->fotos->count() > 0)
                <div class="rounded-4 overflow-hidden mb-3" style="background:#f8fafc;">
                    <img src="{{ asset('storage/' . $produto->fotos->first()->arquivo) }}"
                         class="w-100"
                         style="max-height:400px;object-fit:contain;"
                         id="fotoDestaque">
                </div>
                @if($produto->fotos->count() > 1)
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($produto->fotos as $foto)
                    <div class="rounded-3 overflow-hidden border" style="width:70px;height:70px;cursor:pointer;background:#f8fafc;"
                         onclick="document.getElementById('fotoDestaque').src='{{ asset('storage/' . $foto->arquivo) }}'">
                        <img src="{{ asset('storage/' . $foto->arquivo) }}" style="width:100%;height:100%;object-fit:contain;">
                    </div>
                    @endforeach
                </div>
                @endif
            @else
                <div class="rounded-4 bg-light d-flex align-items-center justify-content-center" style="height:300px;">
                    <div class="text-center text-muted">
                        <i class="bi bi-image fs-1"></i>
                        <p class="small mt-2">Sem foto</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-6 ps-md-5">
            @if($produto->categoria)
                <span class="badge mb-2" style="background:#f0fdf4;color:#15803D;font-size:0.8rem;">
                    <i class="bi bi-tag me-1"></i>{{ $produto->categoria->nome }}
                </span>
            @endif

            <h2 class="fw-700 mb-3" style="color:#1e293b;">{{ $produto->nome }}</h2>

            @if($produto->temPromocao())
                <p class="text-muted text-decoration-line-through mb-0">
                    R$ {{ number_format($produto->valor, 2, ',', '.') }}
                </p>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <h3 class="fw-700 text-danger mb-0">
                        R$ {{ number_format($produto->valorComDesconto(), 2, ',', '.') }}
                    </h3>
                    <span class="badge" style="background:linear-gradient(135deg,#ef4444,#dc2626);font-size:0.85rem;">
                        -{{ number_format((1 - $produto->valorComDesconto() / $produto->valor) * 100, 0) }}%
                    </span>
                </div>
            @else
                <h3 class="fw-700 mb-3" style="color:#15803D;">
                    R$ {{ number_format($produto->valor, 2, ',', '.') }}
                </h3>
            @endif

            <div class="d-flex align-items-center gap-2 mb-3 p-3 rounded-3" style="background:#f0fdf4;">
                <i class="bi bi-box-seam" style="color:#15803D;"></i>
                <span style="color:#15803D;font-weight:600;">
                    {{ $produto->estoque }} unidades disponíveis
                </span>
            </div>

            @if($produto->descricao)
                <div class="mb-4 border rounded-3">
                    <button class="btn w-100 text-start d-flex justify-content-between align-items-center px-3 py-2"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#descricaoProduto"
                            style="background:#f8fafc;color:#6b7280;font-weight:500;">
                        Descrição do Produto
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="collapse p-3" id="descricaoProduto">
                        <div class="descricao-produto" style="line-height:1.7;">
                            {!! $produto->descricao !!}
                        </div>
                    </div>
                </div>
            @endif

            @auth
                @if(!auth()->user()->isAdmin() && $produto->estoque > 0)
                    <form method="POST" action="{{ route('cliente.carrinho.adicionar') }}">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <div class="d-flex gap-2">
                            <input type="number" name="quantidade" value="1" min="1" max="{{ $produto->estoque }}"
                                   class="form-control bg-light border-0 text-center"
                                   style="width:80px;border-radius:10px;">
                            <button class="btn btn-verde px-4 fw-600" style="border-radius:10px;">
                                <i class="bi bi-cart-plus me-2"></i>Adicionar ao carrinho
                            </button>
                        </div>
                    </form>
                @elseif($produto->estoque == 0)
                    <div class="p-3 rounded-3 text-center" style="background:#fff1f2;color:#e11d48;">
                        <i class="bi bi-x-circle me-2"></i>Produto fora de estoque
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-verde w-100 py-2 fw-600" style="border-radius:10px;">
                    <i class="bi bi-person me-2"></i>Faça login para comprar
                </a>
            @endauth

            <hr class="my-4">
            <a href="{{ route('home') }}" class="text-muted text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i>Voltar para a loja
            </a>
        </div>
    </div>
</div>
@endsection