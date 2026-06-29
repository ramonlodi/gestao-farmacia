@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <div style="width:48px;height:48px;background:linear-gradient(135deg,#15803D,#2563EB);border-radius:14px;display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-speedometer2 text-white fs-5"></i>
    </div>
    <div>
        <h3 class="mb-0 fw-700">Painel Administrativo</h3>
        <p class="text-muted small mb-0">Gerencie todos os recursos da UltraMed Farma</p>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('admin.categorias.index') }}" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100" style="transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#f0fdf4;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-folder2" style="color:#15803D;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-700">Categorias</h6>
                            <p class="text-muted small mb-0">Gerenciar categorias</p>
                        </div>
                        <i class="bi bi-arrow-right ms-auto text-muted"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.produtos.index') }}" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100" style="transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-capsule" style="color:#2563EB;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-700">Produtos</h6>
                            <p class="text-muted small mb-0">Gerenciar produtos</p>
                        </div>
                        <i class="bi bi-arrow-right ms-auto text-muted"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.fornecedores.index') }}" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100" style="transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#fefce8;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-building" style="color:#ca8a04;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-700">Fornecedores</h6>
                            <p class="text-muted small mb-0">Gerenciar fornecedores</p>
                        </div>
                        <i class="bi bi-arrow-right ms-auto text-muted"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.cidades.index') }}" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100" style="transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#f0f9ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-geo-alt" style="color:#0284c7;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-700">Cidades</h6>
                            <p class="text-muted small mb-0">Gerenciar cidades</p>
                        </div>
                        <i class="bi bi-arrow-right ms-auto text-muted"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.promocoes.index') }}" class="text-decoration-none">
            <div class="card border-0 rounded-4 shadow-sm h-100" style="transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:48px;height:48px;background:#fff1f2;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-tag" style="color:#e11d48;font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-700">Promoções</h6>
                            <p class="text-muted small mb-0">Gerenciar promoções</p>
                        </div>
                        <i class="bi bi-arrow-right ms-auto text-muted"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection