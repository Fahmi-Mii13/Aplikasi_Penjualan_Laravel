<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TOKO</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="login-wrapper">
    <div class="card login-card">
        <h2 class="text-center mb-2" style="font-weight: 800; color: var(--primary); font-size: 2rem;">TOKO</h2>
        <p class="text-center text-muted mb-4">Masuk ke aplikasi penjualan</p>
        
        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem; padding: 0.8rem;">Log in</button>
        </form>
    </div>
</body>
</html>
