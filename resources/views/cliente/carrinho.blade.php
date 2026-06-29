@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <div style="width:48px;height:48px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:14px;display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-cart3 text-white fs-5"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-700">Meu Carrinho</h3>
        <p class="text-muted small mb-0">{{ count($carrinho) }} {{ count($carrinho) == 1 ? 'item' : 'itens' }}</p>
    </div>
</div>

@if(empty($carrinho))
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
        <i class="bi bi-cart-x" style="font-size:4rem;color:#cbd5e1;"></i>
        <h5 class="mt-3 text-muted">Seu carrinho está vazio</h5>
        <a href="{{ route('home') }}" class="btn btn-verde mt-3 px-4" style="border-radius:10px;">
            <i class="bi bi-arrow-left me-2"></i>Ver produtos
        </a>
    </div>
@else
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <table class="table mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="py-3 ps-4">Produto</th>
                        <th class="py-3">Preço</th>
                        <th class="py-3">Quantidade</th>
                        <th class="py-3">Subtotal</th>
                        <th class="py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrinho as $item)
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td class="py-3 ps-4 fw-600">{{ $item['nome'] }}</td>
                        <td class="py-3 text-muted">R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                        <td class="py-3">{{ $item['quantidade'] }}</td>
                        <td class="py-3 fw-700" style="color:#15803D;">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</td>
                        <td class="py-3">
                            <form method="POST" action="{{ route('cliente.carrinho.remover') }}">
                                @csrf
                                <input type="hidden" name="produto_id" value="{{ $item['produto_id'] }}">
                                <button class="btn btn-sm" style="background:#fff1f2;color:#e11d48;border-radius:8px;">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('home') }}" class="btn mt-3" style="background:#f1f5f9;color:#475569;border-radius:10px;">
            <i class="bi bi-arrow-left me-2"></i>Continuar comprando
        </a>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h6 class="fw-700 mb-3">Resumo do pedido</h6>
            <div class="d-flex justify-content-between mb-2 text-muted small">
                <span>Subtotal</span>
                <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 text-muted small">
                <span>Entrega</span>
                <span class="text-success">Grátis</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-700 mb-4">
                <span>Total</span>
                <span style="color:#15803D;font-size:1.2rem;">R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>
            <a href="{{ route('cliente.finalizar') }}" class="btn btn-verde w-100 py-2 fw-600" style="border-radius:10px;">
                <i class="bi bi-bag-check me-2"></i>Finalizar compra
            </a>
        </div>
    </div>
</div>
@endif
@endsection