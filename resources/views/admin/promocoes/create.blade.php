@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:44px;height:44px;background:#fff1f2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-tag-fill" style="color:#e11d48;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-700">Nova Promoção</h5>
                        <p class="text-muted small mb-0">Configure um desconto por categoria</p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.promocoes.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Categoria</label>
                        <select name="categoria_id" class="form-select bg-light border-0" required>
                            <option value="">— Selecione —</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Tipo de Desconto</label>
                        <select name="tipo_desconto" class="form-select bg-light border-0" required>
                            <option value="porcentagem" {{ old('tipo_desconto') == 'porcentagem' ? 'selected' : '' }}>Porcentagem (%)</option>
                            <option value="absoluto" {{ old('tipo_desconto') == 'absoluto' ? 'selected' : '' }}>Valor fixo (R$)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Valor do Desconto</label>
                        <input type="number" name="desconto" class="form-control bg-light border-0" value="{{ old('desconto') }}" step="0.01" min="0" required>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label class="form-label fw-500 small">Data Início</label>
                            <input type="date" name="data_inicio" class="form-control bg-light border-0" value="{{ old('data_inicio') }}" required>
                        </div>
                        <div class="col mb-4">
                            <label class="form-label fw-500 small">Data Fim</label>
                            <input type="date" name="data_fim" class="form-control bg-light border-0" value="{{ old('data_fim') }}" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-verde px-4" style="border-radius:10px;"><i class="bi bi-check2 me-2"></i>Salvar</button>
                        <a href="{{ route('admin.promocoes.index') }}" class="btn px-4" style="background:#f1f5f9;color:#475569;border-radius:10px;">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection