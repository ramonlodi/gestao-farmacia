@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;background:#f0fdf4;border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-folder2" style="color:#15803D;font-size:1.3rem;"></i>
        </div>
        <div>
            <h3 class="mb-0 fw-700">Categorias</h3>
            <p class="text-muted small mb-0">{{ $categorias->count() }} categorias cadastradas</p>
        </div>
    </div>
    <a href="{{ route('admin.categorias.create') }}" class="btn btn-verde px-4" style="border-radius:10px;">
        <i class="bi bi-plus-circle me-2"></i>Nova Categoria
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <table class="table mb-0">
        <thead style="background:#f8fafc;">
            <tr>
                <th class="py-3 ps-4">#</th>
                <th class="py-3">Nome</th>
                <th class="py-3">Categoria Pai</th>
                <th class="py-3">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorias as $categoria)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td class="py-3 ps-4 text-muted small">{{ $categoria->id }}</td>
                <td class="py-3 fw-600">{{ $categoria->nome }}</td>
                <td class="py-3">
                    @if($categoria->pai)
                        <span class="badge" style="background:#f0fdf4;color:#15803D;">{{ $categoria->pai->nome }}</span>
                    @else
                        <span class="text-muted small">—</span>
                    @endif
                </td>
                <td class="py-3">
                    <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-sm me-1" style="background:#f0fdf4;color:#15803D;border-radius:8px;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="background:#fff1f2;color:#e11d48;border-radius:8px;" onclick="return confirm('Confirmar exclusão?')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted py-5">Nenhuma categoria cadastrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection