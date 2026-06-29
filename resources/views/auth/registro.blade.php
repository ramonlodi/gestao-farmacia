@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow rounded-4 p-2">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:16px;">
                        <i class="bi bi-person-plus-fill text-white fs-4"></i>
                    </div>
                    <h4 class="fw-700">Criar conta</h4>
                    <p class="text-muted small">Cadastre-se e compre com facilidade</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('registro') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Nome completo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="nome" class="form-control bg-light border-0" value="{{ old('nome') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">CPF</label>
                            <input type="text" name="cpf" class="form-control bg-light border-0" value="{{ old('cpf') }}" placeholder="000.000.000-00" required>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">RG</label>
                            <input type="text" name="rg" class="form-control bg-light border-0" value="{{ old('rg') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" class="form-control bg-light border-0" value="{{ old('data_nascimento') }}">
                        </div>
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Telefone</label>
                            <input type="text" name="telefone" class="form-control bg-light border-0" value="{{ old('telefone') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Senha</label>
                            <input type="password" name="password" class="form-control bg-light border-0" required>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label fw-500 small">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" class="form-control bg-light border-0" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-verde w-100 py-2 fw-600">
                        <i class="bi bi-person-check me-2"></i>Criar conta
                    </button>
                </form>
                <p class="text-center mt-3 small text-muted">
                    Já tem conta? <a href="{{ route('login') }}" style="color:#15803D;font-weight:600;">Faça login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection