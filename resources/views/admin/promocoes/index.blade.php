@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;background:#fff1f2;border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-tag" style="color:#e11d48;font-size:1.3rem;"></i>
        </div>
        <div>
            <h3 class="mb-0 fw-700">Promoções</h3>
            <p class="text-muted small mb-0">{{ $promocoes->count() }} promoções cadastradas</p>
        </div>
    </div>
    <a href="{{ route('admin.promocoes.create') }}" class="btn btn-verde px-4" style="border-radius:10px;">
        <i class="bi bi-plus-circle me-2"></i>Nova Promoção
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <table class="table mb-0">
        <thead style="background:#f8fafc;">
            <tr>
                <th class="py-3 ps-4">#</th>
                <th class="py-3">Categoria</th>
                <th class="py-3">Desconto</th>
                <th class="py-3">Tipo</th>
                <th class="py-3">Início</th>
                <th class="py-3">Fim</th>
                <th class="py-3">Status</th>
                <th class="py-3">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promocoes as $promocao)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td class="py-3 ps-4 text-muted small">{{ $promocao->id }}</td>
                <td class="py-3 fw-600">{{ $promocao->categoria->nome ?? '—' }}</td>
                <td class="py-3 fw-700" style="color:#e11d48;">{{ $promocao->desconto }}{{ $promocao->tipo_desconto === 'porcentagem' ? '%' : ' R$' }}</td>
                <td class="py-3 text-muted small">{{ $promocao->tipo_desconto === 'porcentagem' ? 'Porcentagem' : 'Valor fixo' }}</td>
                <td class="py-3 text-muted small">{{ $promocao->data_inicio->format('d/m/Y') }}</td>
                <td class="py-3 text-muted small">{{ $promocao->data_fim->format('d/m/Y') }}</td>
                <td class="py-3">
                    @if($promocao->data_fim >= now()->startOfDay() && $promocao->data_inicio <= now())
                        <span class="badge" style="background:#f0fdf4;color:#15803D;">Ativa</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#94a3b8;">Inativa</span>
                    @endif
                </td>
                <td class="py-3">
                    <a href="{{ route('admin.promocoes.edit', $promocao) }}" class="btn btn-sm me-1" style="background:#f0fdf4;color:#15803D;border-radius:8px;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.promocoes.destroy', $promocao) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="background:#fff1f2;color:#e11d48;border-radius:8px;" onclick="return confirm('Confirmar exclusão?')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-5">Nenhuma promoção cadastrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection