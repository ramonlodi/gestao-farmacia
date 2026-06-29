@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card border-0 shadow rounded-4 p-2">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:16px;">
                        <i class="bi bi-person-fill text-white fs-4"></i>
                    </div>
                    <h4 class="fw-700">Bem-vindo de volta</h4>
                    <p class="text-muted small">Entre na sua conta UltraMed Farma</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-3"><i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-500 small">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0" placeholder="seu@email.com" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-500 small">Senha</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-0" placeholder="••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-verde w-100 py-2 fw-600">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                    </button>
                </form>
                <p class="text-center mt-3 small text-muted">
                    Não tem conta? <a href="{{ route('registro') }}" style="color:#15803D;font-weight:600;">Cadastre-se</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection