<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tododo') - Simple Todo App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo">📝 Tododo</h1>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('todos.index') }}" class="nav-item {{ request()->routeIs('todos.*') ? 'active' : '' }}">
                    <span class="nav-icon">📋</span>
                    <span>My Todos</span>
                </a>
                <a href="{{ route('categories.index') }}" class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <span class="nav-icon">📁</span>
                    <span>Categories</span>
                </a>
                <a href="{{ route('tags.index') }}" class="nav-item {{ request()->routeIs('tags.*') ? 'active' : '' }}">
                    <span class="nav-icon">🏷️</span>
                    <span>Tags</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="main-header">
                <h2 class="page-title">@yield('page-title', 'Dashboard')</h2>
                @yield('header-actions')
            </header>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✓</span>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <span>✗</span>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
