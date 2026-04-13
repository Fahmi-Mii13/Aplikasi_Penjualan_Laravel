@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Tambah Produk Baru</h2>
        <a href="{{ route('products.index') }}" class="btn" style="background:var(--border);">Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Kode Barang</label>
            <input type="text" name="kode" class="form-control" value="{{ old('kode') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" required min="0">
        </div>
        <div class="form-group">
            <label class="form-label">Stok Awal</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" required min="0">
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Produk</button>
    </form>
</div>
@endsection
