@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Daftar Produk</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->kode }}</td>
                <td>{{ $p->nama }}</td>
                <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                <td>{{ $p->stok }}</td>
                <td style="text-align: right; display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <a href="{{ route('products.edit', $p->id) }}" class="btn" style="background:#E5E7EB; color:#111827;">Edit</a>
                    <form action="{{ route('products.destroy', $p->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
