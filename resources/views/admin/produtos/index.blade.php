@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;background:#eff6ff;border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-capsule" style="color:#2563EB;font-size:1.3rem;"></i>
        </div>
        <div>
            <h3 class="mb-0 fw-700">Produtos</h3>
            <p class="text-muted small mb-0">{{ $produtos->count() }} produtos cadastrados</p>
        </div>
    </div>
    <a href="{{ route('admin.produtos.create') }}" class="btn btn-verde px-4" style="border-radius:10px;">
        <i class="bi bi-plus-circle me-2"></i>Novo Produto
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <table class="table mb-0">
        <thead style="background:#f8fafc;">
            <tr>
                <th class="py-3 ps-4">Foto</th>
                <th class="py-3">Nome</th>
                <th class="py-3">Categoria</th>
                <th class="py-3">Estoque</th>
                <th class="py-3">Valor</th>
                <th class="py-3">Fornecedores</th>
                <th class="py-3">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produtos as $produto)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td class="py-3 ps-4">
                    @if($produto->fotos->count() > 0)
                        <img src="{{ asset('storage/' . $produto->fotos->first()->arquivo) }}"
                             style="width:48px;height:48px;object-fit:contain;border-radius:8px;background:#f8fafc;">
                    @else
                        <div style="width:48px;height:48px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                </td>
                <td class="py-3 fw-600">{{ $produto->nome }}</td>
                <td class="py-3">
                    @if($produto->categoria)
                        <span class="badge" style="background:#f0fdf4;color:#15803D;">{{ $produto->categoria->nome }}</span>
                    @else
                        <span class="text-muted small">—</span>
                    @endif
                </td>
                <td class="py-3">
                    <span class="{{ $produto->estoque < 10 ? 'text-danger fw-600' : 'text-muted' }}">
                        {{ $produto->estoque }}
                    </span>
                </td>
                <td class="py-3 fw-600" style="color:#15803D;">R$ {{ number_format($produto->valor, 2, ',', '.') }}</td>
                <td class="py-3">
                    @foreach($produto->fornecedores as $f)
                        <span class="badge me-1" style="background:#f1f5f9;color:#475569;">{{ $f->razao_social }}</span>
                    @endforeach
                </td>
                <td class="py-3">
                    <a href="{{ route('admin.produtos.edit', $produto) }}" class="btn btn-sm me-1" style="background:#f0fdf4;color:#15803D;border-radius:8px;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.produtos.destroy', $produto) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="background:#fff1f2;color:#e11d48;border-radius:8px;" onclick="return confirm('Confirmar exclusão?')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-5">Nenhum produto cadastrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection