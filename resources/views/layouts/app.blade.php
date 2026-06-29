<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UltraMed Farma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        :root {
            --verde: #22C55E;
            --verde-escuro: #15803D;
            --azul: #2563EB;
            --fundo: #F0FDF4;
        }

        body {
            background-color: var(--fundo);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar-ultramed {
            background: linear-gradient(135deg, var(--verde-escuro) 0%, #1a6b4a 50%, var(--azul) 100%);
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
            padding: 12px 0;
        }

        .navbar-brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--verde-escuro);
            font-weight: 900;
        }

        .logo-text {
            line-height: 1.1;
        }

        .logo-text .brand-name {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            display: block;
        }

        .logo-text .brand-sub {
            color: rgba(255,255,255,0.75);
            font-size: 0.7rem;
            display: block;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .nav-btn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: white !important;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .nav-btn:hover {
            background: rgba(255,255,255,0.25);
            color: white !important;
        }

        .nav-btn-primary {
            background: var(--azul);
            border-color: var(--azul);
        }

        .nav-btn-primary:hover {
            background: #1d4ed8;
        }

        .nav-btn-outline {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.5);
        }

        .card-produto {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: all 0.3s;
            overflow: hidden;
            background: white;
        }

        .card-produto:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(34,197,94,0.15);
        }

        .card-produto .card-img-wrapper {
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 180px;
            overflow: hidden;
        }

        .card-produto .card-img-wrapper img {
            max-height: 160px;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.3s;
        }

        .card-produto:hover .card-img-wrapper img {
            transform: scale(1.05);
        }

        .badge-promo {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .btn-verde {
            background: var(--verde);
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-verde:hover {
            background: var(--verde-escuro);
            color: white;
        }

        .btn-azul {
            background: var(--azul);
            border: none;
            color: white;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-azul:hover {
            background: #1d4ed8;
            color: white;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(to right, var(--verde), transparent);
            margin-left: 10px;
        }

        .alert-success { border-left: 4px solid var(--verde); }
        .alert-danger { border-left: 4px solid #ef4444; }

        footer {
            background: linear-gradient(135deg, var(--verde-escuro), #1a3a5c);
            color: rgba(255,255,255,0.85);
            margin-top: 4rem;
            padding: 2rem 0 1rem;
        }

        .ql-toolbar {
            border-radius: 8px 8px 0 0;
            border-color: #e2e8f0 !important;
            background: #f8fafc;
        }

        .ql-container {
            border-color: #e2e8f0 !important;
            font-size: 0.95rem;
        }

        footer a { color: rgba(255,255,255,0.7); text-decoration: none; }
        footer a:hover { color: white; }
    </style>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G0RJW7RTQX"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-G0RJW7RTQX');
    </script>
    
</head>
<body>
    <nav class="navbar navbar-ultramed">
        <div class="container">
            <a class="navbar-brand-logo" href="{{ route('home') }}">
                <div class="logo-icon">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <div class="logo-text">
                    <span class="brand-name">UltraMed Farma</span>
                    <span class="brand-sub">Saúde & Bem-estar</span>
                </div>
            </a>

            <div class="d-flex align-items-center gap-2">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-btn">
                            <i class="bi bi-grid"></i> Painel
                        </a>
                        <a href="{{ route('admin.dashboard.view') }}" class="nav-btn">
                            <i class="bi bi-bar-chart"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="nav-btn">
                            <i class="bi bi-house"></i>
                        </a>
                        <a href="{{ route('cliente.carrinho') }}" class="nav-btn position-relative">
                            <i class="bi bi-cart3"></i> Carrinho
                            @php $totalItens = array_sum(array_column(session()->get('carrinho', []), 'quantidade')); @endphp
                            @if($totalItens > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                    style="background:#ef4444;font-size:0.65rem;padding:3px 6px;">
                                    {{ $totalItens }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('cliente.enderecos.index') }}" class="nav-btn">
                            <i class="bi bi-geo-alt"></i> Endereços
                        </a>
                        <a href="{{ route('cliente.pedidos') }}" class="nav-btn">
                            <i class="bi bi-bag-check"></i> Pedidos
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="nav-btn nav-btn-outline" style="border:none;cursor:pointer;">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-btn">
                        <i class="bi bi-person"></i> Login
                    </a>
                    <a href="{{ route('registro') }}" class="nav-btn nav-btn-primary">
                        <i class="bi bi-person-plus"></i> Cadastrar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-plus-circle-fill text-white fs-4"></i>
                        <span style="color:white;font-weight:700;font-size:1.1rem;">UltraMed Farma</span>
                    </div>
                    <p style="font-size:0.85rem;">Cuidando da sua saúde com qualidade e confiança.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p class="fw-600 text-white mb-2">Atendimento</p>
                    <p style="font-size:0.85rem;"><i class="bi bi-telephone me-1"></i> (49) 3555-0000</p>
                    <p style="font-size:0.85rem;"><i class="bi bi-envelope me-1"></i> contato@ultramedfarma.com.br</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p class="fw-600 text-white mb-2">Localização</p>
                    <p style="font-size:0.85rem;"><i class="bi bi-geo-alt me-1"></i> Caçador, SC</p>
                    <p style="font-size:0.85rem;"><i class="bi bi-clock me-1"></i> Seg–Sex: 8h–18h</p>
                </div>
            </div>
            <hr style="border-color:rgba(255,255,255,0.2);">
            <p class="text-center mb-0" style="font-size:0.8rem;">© 2026 UltraMed Farma. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input[name="cpf"]').mask('000.000.000-00');
            $('input[name="cnpj"]').mask('00.000.000/0000-00');
            $('input[name="telefone"]').mask('(00) 00000-0000');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
</body>
</html>