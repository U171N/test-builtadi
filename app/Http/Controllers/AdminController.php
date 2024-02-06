<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

     //menampilkan halaman dashboard admin
     public function AdminDashboard() {
        $totalRevenue = Order::where('status', 2)
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->sum('order_items.price');

        $totalSoldProducts = Order::where('status', 2)
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->sum('order_items.quantity');

        $totalCustomer = User::where('role', 'customer')->count();


        $orders =Order::with(['orderItems.product','payments','user'])->get();

        return view('admin.index', [
            'totalRevenue' => $totalRevenue,
            'totalSoldProducts' => $totalSoldProducts,
            'totalCustomer' => $totalCustomer,
            'orders' => $orders

        ]);
    }

    //menampilkan halaman login pada login admin
    public function AdminLogin(){
        return view('admin.admin_login');
    }

    //menampilkan data profile  admin pada dashboard
    public function AdminProfile(){
        $id = Auth::user()->id;
        $adminData =User::find($id);
        return view('admin.admin_profile',compact('adminData'));
    }

    //session logout
    public function AdminDestroy(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
