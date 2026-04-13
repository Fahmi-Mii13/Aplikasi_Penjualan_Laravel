<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Penjualan - TOKO</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @auth
    <nav class="navbar">
        <a href="{{ route('dashboard') }}" class="nav-brand">TOKO<span style="color: var(--text-main);">.</span></a>
        
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
            
            @if(Auth::user()->role == 'operator')
                <a href="{{ route('pos.index') }}" class="nav-link">Penjualan</a>
            @endif
            
            @if(in_array(Auth::user()->role, ['admin', 'superadmin']))
                <a href="{{ route('products.index') }}" class="nav-link">Produk</a>
                <a href="{{ route('pos.history') }}" class="nav-link">Riwayat</a>
            @endif
            
            @if(Auth::user()->role == 'superadmin')
                <a href="{{ route('users.index') }}" class="nav-link">Users</a>
            @endif
        </div>
        
        <div class="nav-links" style="border-left: 1px solid var(--border); padding-left: 1.5rem;">
            <span style="font-weight: 600;">{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 1rem;">Logout</button>
            </form>
        </div>
    </nav>
    @endauth

    <main class="main-content">
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
