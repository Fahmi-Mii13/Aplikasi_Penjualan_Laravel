@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Tambah User Baru</h2>
        <a href="{{ route('users.index') }}" class="btn" style="background:var(--border);">Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required style="appearance: auto;">
                <option value="operator">Operator</option>
                <option value="admin">Admin</option>
                <option value="superadmin">Superadmin</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan User</button>
    </form>
</div>
@endsection
