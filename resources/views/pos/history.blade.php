@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2>Riwayat Penjualan Kasir</h2>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Operator</th>
                <th style="text-align: right;">Total Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td><strong>{{ $sale->nomor_penjualan }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($sale->tanggal)->format('d / m / Y') }}</td>
                <td>{{ $sale->user->name }}</td>
                <td style="text-align: right; color: var(--primary); font-weight: 600;">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
