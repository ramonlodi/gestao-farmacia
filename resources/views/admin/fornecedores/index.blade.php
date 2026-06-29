@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div style="width:48px;height:48px;background:#fefce8;border-radius:14px;display:flex;align-items:center;justify-content:center;">
            <i class="bi bi-building" style="color:#ca8a04;font-size:1.3rem;"></i>
        </div>
        <div>
            <h3 class="mb-0 fw-700">Fornecedores</h3>
            <p class="text-muted small mb-0">{{ $fornecedores->count() }} fornecedores cadastrados</p>
        </div>
    </div>
    <a href="{{ route('admin.fornecedores.create') }}" class="btn btn-verde px-4" style="border-radius:10px;">
        <i class="bi bi-plus-circle me-2"></i>Novo Fornecedor
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <table class="table mb-0">
        <thead style="background:#f8fafc;">
            <tr>
                <th class="py-3 ps-4">#</th>
                <th class="py-3">Razão Social</th>
                <th class="py-3">CNPJ</th>
                <th class="py-3">Contato</th>
                <th class="py-3">Email</th>
                <th class="py-3">Telefone</th>
                <th class="py-3">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fornecedores as $fornecedor)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td class="py-3 ps-4 text-muted small">{{ $fornecedor->id }}</td>
                <td class="py-3 fw-600">{{ $fornecedor->razao_social }}</td>
                <td class="py-3 text-muted small">{{ $fornecedor->cnpj }}</td>
                <td class="py-3 text-muted small">{{ $fornecedor->contato ?? '—' }}</td>
                <td class="py-3 text-muted small">{{ $fornecedor->email ?? '—' }}</td>
                <td class="py-3 text-muted small">{{ $fornecedor->telefone ?? '—' }}</td>
                <td class="py-3">
                    <a href="{{ route('admin.fornecedores.edit', $fornecedor) }}" class="btn btn-sm me-1" style="background:#f0fdf4;color:#15803D;border-radius:8px;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.fornecedores.destroy', $fornecedor) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="background:#fff1f2;color:#e11d48;border-radius:8px;" onclick="return confirm('Confirmar exclusão?')">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-5">Nenhum fornecedor cadastrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection