@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:44px;height:44px;background:#fefce8;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-pencil" style="color:#ca8a04;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-700">Editar Fornecedor</h5>
                        <p class="text-muted small mb-0">{{ $fornecedor->razao_social }}</p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.fornecedores.update', $fornecedor) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Razão Social</label>
                        <input type="text" name="razao_social" class="form-control bg-light border-0" value="{{ old('razao_social', $fornecedor->razao_social) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500 small">CNPJ</label>
                        <input type="text" name="cnpj" class="form-control bg-light border-0" value="{{ old('cnpj', $fornecedor->cnpj) }}" required>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Contato</label>
                            <input type="text" name="contato" class="form-control bg-light border-0" value="{{ old('contato', $fornecedor->contato) }}">
                        </div>
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Telefone</label>
                            <input type="text" name="telefone" class="form-control bg-light border-0" value="{{ old('telefone', $fornecedor->telefone) }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-500 small">Email</label>
                        <input type="email" name="email" class="form-control bg-light border-0" value="{{ old('email', $fornecedor->email) }}">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-verde px-4" style="border-radius:10px;"><i class="bi bi-check2 me-2"></i>Atualizar</button>
                        <a href="{{ route('admin.fornecedores.index') }}" class="btn px-4" style="background:#f1f5f9;color:#475569;border-radius:10px;">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection