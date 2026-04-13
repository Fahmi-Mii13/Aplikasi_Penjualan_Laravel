<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $stats = [];
        
        if (in_array($role, ['admin', 'superadmin'])) {
            $stats['total_sales'] = Sale::count();
            $stats['total_revenue'] = Sale::sum('total');
            $stats['total_products'] = Product::count();
            if ($role == 'superadmin') {
                $stats['total_users'] = User::count();
            }
        }
        
        return view('dashboard', compact('stats', 'role'));
    }
}
