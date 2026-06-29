@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:44px;height:44px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-geo-alt text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-700">Novo Endereço</h5>
                        <p class="text-muted small mb-0">Preencha os dados do endereço</p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('cliente.enderecos.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Descrição (ex: Casa, Trabalho)</label>
                        <input type="text" name="descricao" class="form-control bg-light border-0" value="{{ old('descricao') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500 small">CEP</label>
                        <input type="text" name="cep" class="form-control bg-light border-0"
                            value="{{ old('cep') }}" placeholder="00000-000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Logradouro</label>
                        <input type="text" name="logradouro" class="form-control bg-light border-0" value="{{ old('logradouro') }}" required>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Número</label>
                            <input type="text" name="numero" class="form-control bg-light border-0" value="{{ old('numero') }}" required>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Bairro</label>
                            <input type="text" name="bairro" class="form-control bg-light border-0" value="{{ old('bairro') }}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-500 small">Cidade</label>
                        <select name="cidade_id" class="form-select bg-light border-0" required>
                            <option value="">— Selecione —</option>
                            @foreach($cidades as $cidade)
                                <option value="{{ $cidade->id }}" {{ old('cidade_id') == $cidade->id ? 'selected' : '' }}>
                                    {{ $cidade->nome }} / {{ $cidade->estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-verde px-4" style="border-radius:10px;">
                            <i class="bi bi-check2 me-2"></i>Salvar
                        </button>
                        <a href="{{ route('cliente.enderecos.index') }}" class="btn px-4" style="background:#f1f5f9;color:#475569;border-radius:10px;">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection