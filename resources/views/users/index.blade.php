@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Daftar User</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Nama</th>
                <th>Role</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->name }}</td>
                <td>
                    <span style="background:var(--bg-color); padding: 0.25rem 0.75rem; border-radius:1rem; font-size:0.875rem;">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn" style="background:#E5E7EB; color:#111827;">Edit</a>
                    @if(Auth::user()->id !== $user->id)
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
