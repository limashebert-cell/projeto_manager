<!DOCTYPE html>
<!-- 
    Sistema de Gestão Empresarial
    Desenvolvido por: Hebert Design
    Data: {{ date('Y') }}
    Tecnologias: Laravel, Bootstrap, JavaScript
-->
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body { 
            background: #fff; 
            font-family: system-ui, sans-serif;
            font-size: 13px;
            line-height: 1.3;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar { 
            background: #343a40 !important; 
            border-bottom: 1px solid #dee2e6;
            box-shadow: none;
            padding: 4px 8px;
        }
        .navbar-brand { 
            font-size: 16px; 
            font-weight: 600; 
        }
        .nav-link { 
            color: #fff !important; 
            padding: 4px 8px;
            font-size: 13px;
        }
        .nav-link:hover { 
            background: rgba(255,255,255,0.1); 
        }
        .main-content { 
            padding: 10px;
            flex: 1;
        }
        .card { 
            border: 1px solid #dee2e6; 
            border-radius: 3px;
            box-shadow: none;
            margin-bottom: 10px;
        }
        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 6px 10px;
            font-weight: 600;
            font-size: 14px;
        }
        
        /* Footer Hebert Design */
        .footer {
            background: #f8f9fa !important;
            border-top: 2px solid #e9ecef;
            font-size: 12px;
            margin-top: auto;
        }
        .footer .text-primary {
            color: #0d6efd !important;
            font-weight: 600;
        }
        .footer .text-muted {
            color: #6c757d !important;
        }
        }
        .card-body {
            padding: 10px;
        }
        .btn { 
            border-radius: 3px; 
            font-size: 13px;
            padding: 4px 8px;
        }
        .form-control { 
            border-radius: 3px; 
            border: 1px solid #ced4da;
            font-size: 13px;
            padding: 4px 8px;
        }
        .table { 
            font-size: 13px; 
            margin-bottom: 0;
        }
        .table th { 
            background: #f8f9fa; 
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            padding: 6px 8px;
        }
        .table td { 
            padding: 6px 8px; 
            vertical-align: middle;
        }
        .alert { 
            border-radius: 3px; 
            font-size: 13px;
            margin-bottom: 10px;
            padding: 8px 12px;
        }
        .badge { 
            font-size: 11px; 
        }
        h1, h2, h3, h4, h5 {
            margin-bottom: 8px;
        }
        .container-fluid {
            padding: 0;
        }
        
        /* Ajustes específicos para tabelas */
        .table-responsive {
            border-radius: 0;
        }
        
        .card-body.p-0 .table {
            margin-bottom: 0;
        }
        
        /* Avatar circle compacto */
        .avatar-circle {
            width: 24px;
            height: 24px;
            background: #6c757d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 11px;
        }
        
        /* Botões compactos */
        .btn-sm {
            padding: 2px 6px;
            font-size: 11px;
        }
        
        /* Layout compacto */
        .main-content {
            padding-top: 5px;
            min-height: calc(100vh - 40px);
        }
        
        .container-fluid {
            padding: 0;
        }
        
        .row {
            margin: 0;
        }
        
        /* Formulários compactos */
        .form-group {
            margin-bottom: 8px;
        }
        
        .form-label {
            font-size: 13px;
            margin-bottom: 2px;
        }
        
        /* Botões do menu principal */
        .btn-menu-principal {
            transition: all 0.3s ease;
            border: 2px solid;
            min-height: 120px;
        }
        
        .btn-menu-principal:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .btn-menu-principal i {
            transition: transform 0.3s ease;
        }
        
        .btn-menu-principal:hover i {
            transform: scale(1.1);
        }
        
        /* Responsividade compacta */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                width: 100%;
            }
            
            .main-content {
                padding: 8px;
            }
            
            .card {
                margin-bottom: 8px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        @auth('admin')
            <!-- Navbar -->
            <nav class="navbar navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-cogs me-2"></i>
                        <span>Painel Admin</span>
                        <small class="ms-2 text-muted" style="font-size: 10px;">by Hebert Design</small>
                    </a>
                    
                    <ul class="navbar-nav d-flex flex-row">
                        <li class="nav-item">
                            <span class="nav-link text-light me-3">
                                <i class="fas fa-user me-1"></i>
                                {{ Auth::guard('admin')->user()->name ?? 'Usuário' }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout.get') }}">
                                <i class="fas fa-sign-out-alt me-1"></i>Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="main-content">
        @else
            <main class="container-fluid p-4">
        @endauth
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
            
            <!-- Footer com marca -->
            <footer class="footer mt-auto py-2 bg-light border-top">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <span class="text-muted small">
                                © {{ date('Y') }} Sistema de Gestão - Todos os direitos reservados
                            </span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="text-muted small">
                                <i class="fas fa-code me-1"></i>
                                Desenvolvido por <strong class="text-primary">Hebert Design</strong>
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    

    
    @stack('scripts')
</body>
</html>