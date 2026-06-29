<div class="col">
    <div class="card card-produto h-100">
        <a href="{{ route('produto.show', $produto->slug) }}" class="text-decoration-none">
            <div class="card-img-wrapper position-relative">
                @if($produto->fotos->count() > 0)
                    <img src="{{ asset('storage/' . $produto->fotos->first()->arquivo) }}" alt="{{ $produto->nome }}">
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                        <i class="bi bi-image fs-1"></i>
                        <small>Sem foto</small>
                    </div>
                @endif
                @if($produto->temPromocao())
                    <span class="badge-promo position-absolute top-0 start-0 m-2">
                        -{{ number_format((1 - $produto->valorComDesconto() / $produto->valor) * 100, 0) }}%
                    </span>
                @endif
            </div>
        </a>
        <div class="card-body pb-1">
            <h6 class="mb-1" style="font-size:0.9rem;font-weight:600;color:#1e293b;">
                <a href="{{ route('produto.show', $produto->slug) }}" class="text-decoration-none text-dark">
                    {{ $produto->nome }}
                </a>
            </h6>
            <p class="text-muted mb-1" style="font-size:0.75rem;">{{ $produto->categoria->nome ?? '' }}</p>
            @if($produto->temPromocao())
                <p class="mb-0 text-muted text-decoration-line-through" style="font-size:0.8rem;">R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
                <p class="fw-700 text-danger mb-1" style="font-size:1rem;">R$ {{ number_format($produto->valorComDesconto(), 2, ',', '.') }}</p>
            @else
                <p class="fw-700 mb-1" style="font-size:1rem;color:#15803D;">R$ {{ number_format($produto->valor, 2, ',', '.') }}</p>
            @endif
            <p class="text-muted mb-0" style="font-size:0.75rem;"><i class="bi bi-box-seam me-1"></i>{{ $produto->estoque }} em estoque</p>
        </div>
        <div class="card-footer border-0 bg-white pt-0 pb-3 px-3">
            @auth
                @if(!auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('cliente.carrinho.adicionar') }}">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <div class="input-group input-group-sm">
                            <input type="number" name="quantidade" value="1" min="1" max="{{ $produto->estoque }}" class="form-control" style="border-radius:8px 0 0 8px;">
                            <button class="btn btn-verde btn-sm" style="border-radius:0 8px 8px 0;">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </div>
                    </form>
                @else
                    <a href="{{ route('admin.produtos.edit', $produto) }}" class="btn btn-sm w-100" style="background:#f1f5f9;color:#475569;border-radius:8px;">
                        <i class="bi bi-pencil me-1"></i>Editar
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-sm w-100 btn-verde">
                    <i class="bi bi-person me-1"></i>Login para comprar
                </a>
            @endauth
        </div>
    </div>
</div>