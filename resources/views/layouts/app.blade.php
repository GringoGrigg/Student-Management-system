<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 20px; background: #f0f2f5; }
        .container { max-width: 1200px; }
        .card { margin-bottom: 20px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card-header { background: #2c3e50; color: white; border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background: #3498db; border: none; }
        .btn-primary:hover { background: #2980b9; }
        .btn-danger { background: #e74c3c; border: none; }
        .btn-danger:hover { background: #c0392b; }
        .btn-success { background: #2ecc71; border: none; }
        .btn-success:hover { background: #27ae60; }
        .btn-warning { background: #f39c12; border: none; color: white; }
        .btn-warning:hover { background: #e67e22; color: white; }
        .table th { background: #34495e; color: white; }
        .status-active { background: #2ecc71; color: white; padding: 3px 10px; border-radius: 20px; font-size: 12px; }
        .status-inactive { background: #e74c3c; color: white; padding: 3px 10px; border-radius: 20px; font-size: 12px; }
        .status-graduated { background: #f39c12; color: white; padding: 3px 10px; border-radius: 20px; font-size: 12px; }
        .navbar-custom { background: #2c3e50; padding: 15px 0; margin-bottom: 30px; }
        .navbar-custom .navbar-brand { color: white !important; font-weight: bold; font-size: 24px; }
        .navbar-custom .nav-link { color: rgba(255,255,255,0.8) !important; }
        .navbar-custom .nav-link:hover { color: white !important; }
        .alert { margin-bottom: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('students.index') }}">
                🎓 Student Management System
            </a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>