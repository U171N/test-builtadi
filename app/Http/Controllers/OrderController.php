<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //menampilakn data order Customer
    public function orderCustomer(){
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
    ->with(['orderItems.product' ])
    ->get();

return view('customer.order.order_details', compact('orders'));

        return view('customer.order.order_details', compact('orders'));
    }


    /*Kelola Order pada bagian user ADMIN */

     //endpoint pending order pada user admin
     public function pendingOrderAdmin(){
        $orders = Order::with(['orderItems.product','user'])
        ->where('status', 0)
        ->get();
        return view('admin.order.prosesOrder',compact('orders'));
    }

    //endpoint pesanan dikirim pada user admin
    public function orderDikirimAdmin(){
        $orders = Order::with(['orderItems.product','user'])
        ->where('status', 1)
        ->get();
        return view('admin.order.KirimOrder',compact('orders'));
    }

    //endpoint pesanan selesai pada user admin
    public function orderSelesaiAdmin(){
        $orders = Order::with(['orderItems.product','user'])
        ->where('status',2)
        ->get();
        return view('admin.order.selesaiOrder',compact('orders'));
    }

    //endpoint pesanan dibatalkan pada user admin
    public function orderCancelAdmin(){
        $orders = Order::with(['orderItems.product','user'])
        ->where('status',3)
        ->get();
        return view('admin.order.BatalOrder',compact('orders'));
    }


     //endpoint untuk verfikasi status order pada user Admin
public function updateOrderStatusAdmin(Request $request) {
    $orderId = $request->input('orderId');
    $newStatus = $request->input('orderStatus');

    // menemukan data berdasarkan order_id
    $order = Order::where('order_id', $orderId)->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Update data status order
    $order->status = $newStatus;
    $order->save();

    return response()->json(['message' => 'Order status updated successfully']);
}


    //endpoint untuk verifikasi status pembayaran pada user Admin
    public function updatePaymentStatusAdmin(Request $request) {
        $orderId = $request->input('orderId');
        $newPaymentStatus = $request->input('paymentStatus');

        // memilih data berdasarkan id order
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // menemukan data payment berdasarkan order_id yang berelasi
        $payments = $order->payments;

        if ($payments->isEmpty()) {
            return response()->json(['message' => 'Order payment not found'], 404);
        }

        // update data status payment
        foreach ($payments as $payment) {
            $payment->status_pembayaran = $newPaymentStatus;
            $payment->save();
        }

        return response()->json(['message' => 'Payment status updated successfully']);
    }
}
