@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:44px;height:44px;background:#f0fdf4;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-folder-plus" style="color:#15803D;"></i>
                    </div>
                    <h5 class="mb-0 fw-700">Nova Categoria</h5>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.categorias.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Nome</label>
                        <input type="text" name="nome" class="form-control bg-light border-0" value="{{ old('nome') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-500 small">Categoria Pai (opcional)</label>
                        <select name="categoria_pai_id" class="form-select bg-light border-0">
                            <option value="">— Nenhuma —</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_pai_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-verde px-4" style="border-radius:10px;"><i class="bi bi-check2 me-2"></i>Salvar</button>
                        <a href="{{ route('admin.categorias.index') }}" class="btn px-4" style="background:#f1f5f9;color:#475569;border-radius:10px;">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection