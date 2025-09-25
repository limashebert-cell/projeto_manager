<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { 
            background: #fff; 
            font-family: system-ui, sans-serif;
            font-size: 13px;
            line-height: 1.3;
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
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        Painel Admin
                    </a>
                    
                    <ul class="navbar-nav d-flex flex-row">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        
                        @if(Auth::guard('admin')->user()->isSuperAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">Usuários</a>
                            </li>
                        @endif
                        
                        <!-- Botões para Gestores -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('presencas.index') }}">Absenteísmo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('colaboradores.index') }}">Colaboradores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('quase-acidentes.index') }}">Quase Acidente</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout.get') }}">Sair</a>
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
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    

    
    @stack('scripts')
</body>
</html>