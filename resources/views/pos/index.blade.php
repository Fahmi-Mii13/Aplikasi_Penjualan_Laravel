@extends('layouts.app')

@section('content')
<div style="display: flex; gap: 2rem; flex-wrap: wrap;">
    <!-- Panel Kiri: Input Barang -->
    <div class="card" style="flex: 1; min-width: 300px; height: fit-content;">
        <h2 style="margin-bottom: 1.5rem;">Pencarian Barang</h2>
        
        <form action="{{ route('pos.index') }}" method="GET" style="margin-bottom: 2rem;">
            <div class="form-group" style="display: flex; gap: 1rem;">
                <input type="text" name="kodeBarang" class="form-control" placeholder="Masukkan Kode Barang..." value="{{ request('kodeBarang') }}" autofocus>
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        @if($searchProduct)
            <div style="background: var(--bg-color); padding: 1.5rem; border-radius: 0.5rem; border: 1px solid var(--border);">
                <form action="{{ route('pos.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $searchProduct->id }}">
                    
                    <div style="margin-bottom: 1rem;">
                        <small class="text-muted">Kode Barang</small>
                        <div style="font-weight: 600; font-size: 1.1rem;">{{ $searchProduct->kode }}</div>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <small class="text-muted">Nama Barang</small>
                        <div style="font-weight: 600; font-size: 1.25rem; color: var(--primary);">{{ $searchProduct->nama }}</div>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between;">
                        <div>
                            <small class="text-muted">Harga</small>
                            <div style="font-weight: 600;">Rp {{ number_format($searchProduct->harga, 0, ',', '.') }}</div>
                        </div>
                        <div style="text-align: right;">
                            <small class="text-muted">Stok Tersedia</small>
                            <div style="font-weight: 600; {{ $searchProduct->stok < 10 ? 'color: var(--danger);' : '' }}">{{ $searchProduct->stok }}</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah Beli</label>
                        <div style="display: flex; gap: 1rem;">
                            <input type="number" name="jumlahBarang" class="form-control" value="1" min="1" max="{{ $searchProduct->stok }}" required>
                            <button type="submit" class="btn btn-primary" style="white-space: nowrap;">Tambah ke Keranjang</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Panel Kanan: Keranjang -->
    <div class="card" style="flex: 2; min-width: 500px;">
        <h2 style="margin-bottom: 1.5rem;">Keranjang Belanja</h2>

        <div class="table-container" style="margin-bottom: 2rem;">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($carts as $cart)
                    <tr>
                        <td>{{ $cart->product->kode }}</td>
                        <td>{{ $cart->product->nama }}</td>
                        <td>Rp {{ number_format($cart->product->harga, 0, ',', '.') }}</td>
                        <td>{{ $cart->jumlah }}</td>
                        <td style="font-weight: 600;">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('pos.remove', $cart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Batal</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada barang di keranjang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="background: var(--bg-color); padding: 2rem; border-radius: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 1.25rem; font-weight: 600; color: var(--text-muted);">Total Belanja</div>
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">Rp {{ number_format($total, 0, ',', '.') }}</div>
            </div>
            @if(count($carts) > 0)
                <form action="{{ route('pos.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="padding: 1.25rem 2.5rem; font-size: 1.25rem; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);">Simpan Transaksi!</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
