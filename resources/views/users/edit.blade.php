@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Edit User</h2>
        <a href="{{ route('users.index') }}" class="btn" style="background:var(--border);">Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required style="appearance: auto;">
                <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Perbarui User</button>
    </form>
</div>
@endsection
