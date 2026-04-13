<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();
        $total = $carts->sum('subtotal');
        
        $searchProduct = null;
        if($request->has('kodeBarang') && !empty($request->kodeBarang)) {
            $searchProduct = Product::where('kode', $request->kodeBarang)->first();
            if(!$searchProduct) {
                return redirect()->route('pos.index')->with('error', 'Barang tidak ditemukan.');
            }
        }

        return view('pos.index', compact('carts', 'total', 'searchProduct'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $jumlah = $request->jumlahBarang;
        
        if($jumlah < 1) {
             return redirect()->route('pos.index')->with('error', 'Jumlah harus lebih besar dari 0.');
        }

        if($product->stok < $jumlah) {
            return redirect()->route('pos.index')->with('error', 'Stok barang tidak mencukupi. Sisa stok: ' . $product->stok);
        }

        $user = Auth::user();
        
        $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();
        if($cart) {
            $cart->jumlah += $jumlah;
            $cart->subtotal = $cart->jumlah * $product->harga;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'jumlah' => $jumlah,
                'subtotal' => $jumlah * $product->harga,
            ]);
        }

        return redirect()->route('pos.index')->with('success', 'Barang ditambahkan ke keranjang.');
    }

    public function removeFromCart($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return redirect()->route('pos.index')->with('success', 'Barang dihapus dari keranjang.');
    }

    public function checkout()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->get();
        
        if($carts->isEmpty()) {
            return redirect()->route('pos.index')->with('error', 'Keranjang masih kosong.');
        }

        DB::transaction(function() use ($carts, $user) {
            $total = $carts->sum('subtotal');
            $nomor_penjualan = 'INV-' . date('YmdHis') . '-' . rand(10, 99);
            
            $sale = Sale::create([
                'nomor_penjualan' => $nomor_penjualan,
                'tanggal' => date('Y-m-d'),
                'total' => $total,
                'user_id' => $user->id,
            ]);

            foreach($carts as $c) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $c->product_id,
                    'harga' => $c->product->harga,
                    'jumlah' => $c->jumlah,
                    'subtotal' => $c->subtotal,
                ]);
                $c->product->decrement('stok', $c->jumlah);
            }
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('pos.index')->with('success', 'Transaksi Penjualan berhasil diselesaikan.');
    }

    public function history()
    {
        $sales = Sale::with('user')->orderBy('created_at', 'desc')->get();
        return view('pos.history', compact('sales'));
    }
}
