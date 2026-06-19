<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management System')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body { 
            padding-top: 20px; 
            background: #f0f2f5; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container { max-width: 1200px; }
        
        .card { 
            margin-bottom: 20px; 
            border-radius: 12px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
        }
        .card-header { 
            background: #2c3e50; 
            color: white; 
            border-radius: 12px 12px 0 0 !important;
            padding: 15px 20px;
        }
        .card-body {
            padding: 20px;
        }
        
        .btn-primary { background: #3498db; border: none; }
        .btn-primary:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; border: none; }
        .btn-danger:hover { background: #c0392b; }
        .btn-success { background: #2ecc71; border: none; }
        .btn-success:hover { background: #27ae60; }
        .btn-warning { background: #f39c12; border: none; color: white; }
        .btn-warning:hover { background: #e67e22; color: white; }
        .btn-secondary { background: #95a5a6; border: none; }
        .btn-secondary:hover { background: #7f8c8d; }
        
        .table th { 
            background: #34495e; 
            color: white;
            font-weight: 500;
            padding: 12px;
        }
        .table td {
            padding: 12px;
            vertical-align: middle;
        }
        
        .status-active { 
            background: #2ecc71; 
            color: white; 
            padding: 3px 12px; 
            border-radius: 20px; 
            font-size: 12px;
            font-weight: 500;
        }
        .status-inactive { 
            background: #e74c3c; 
            color: white; 
            padding: 3px 12px; 
            border-radius: 20px; 
            font-size: 12px;
            font-weight: 500;
        }
        .status-graduated { 
            background: #f39c12; 
            color: white; 
            padding: 3px 12px; 
            border-radius: 20px; 
            font-size: 12px;
            font-weight: 500;
        }
        
        .navbar-custom { 
            background: #2c3e50; 
            padding: 12px 0; 
            margin-bottom: 30px;
            border-radius: 0;
        }
        .navbar-custom .navbar-brand { 
            color: white !important; 
            font-weight: bold; 
            font-size: 24px; 
        }
        .navbar-custom .nav-link { 
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover { 
            color: white !important;
        }
        .navbar-custom .nav-link.active { 
            color: white !important; 
            font-weight: bold;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .profile-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #3498db;
        }
        
        .profile-photo-large {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #3498db;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('students.index') }}">
                🎓 Student Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}" 
                           href="{{ route('students.index') }}">
                            <i class="bi bi-list-ul"></i> Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('students.trashed') ? 'active' : '' }}" 
                           href="{{ route('students.trashed') }}">
                            <i class="bi bi-trash"></i> Trash
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('students.create') }}">
                            <i class="bi bi-plus-circle"></i> Add Student
                        </a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>