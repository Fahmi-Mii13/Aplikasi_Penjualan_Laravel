@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="color: var(--text-main); font-size: 1.8rem; font-weight: 700;">Dashboard</h1>
        <p style="color: var(--text-muted); margin-top: 0.5rem;">Selamat Datang, <strong>{{ Auth::user()->name }}</strong> (Akses: {{ ucfirst($role) }})</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
    @if(in_array($role, ['admin', 'superadmin']))
    <div class="card" style="padding: 1.5rem;">
        <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Pendapatan</h3>
        <p style="font-size: 2rem; font-weight: 700; color: var(--primary);">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
    </div>
    <div class="card" style="padding: 1.5rem;">
        <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Penjualan</h3>
        <p style="font-size: 2rem; font-weight: 700; color: var(--text-main);">{{ $stats['total_sales'] ?? 0 }} Transaksi</p>
    </div>
    <div class="card" style="padding: 1.5rem;">
        <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Total Produk</h3>
        <p style="font-size: 2rem; font-weight: 700; color: var(--text-main);">{{ $stats['total_products'] ?? 0 }} Item</p>
    </div>
    @endif
    
    @if($role == 'operator')
    <div class="card" style="grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4rem 2rem;">
        <h2 style="margin-bottom: 1rem;">Mulai Transaksi Kasir</h2>
        <a href="{{ route('pos.index') }}" class="btn btn-primary" style="font-size: 1.25rem; padding: 1rem 2rem;">Buka Halaman Penjualan</a>
    </div>
    @endif
</div>
@endsection
