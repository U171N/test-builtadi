<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatOrderController extends Controller
{
    //menampilkan riwayat hasil order pada customer
    public function RiwayatOrderCustomer(){
        $user =Auth::user();
        $riwayatPesanan=Order::where('user_id',$user->id)
        ->with(['orderItems.product','payments'])
        ->get();
        return view('customer.order.riwayatOrder',compact('riwayatPesanan'));
    }

       //endpoint konfirmasi terima pesanan
       public function updateStatus(Request $request)
       {
           $orderId = $request->input('orderId');
           $newStatus = $request->input('newStatus');

           // Update the order status in the database
           $order = Order::find($orderId);
           if (!$order) {
               return response()->json(['error' => 'Order not found'], 404);
           }

           $order->status = $newStatus;
           $order->save();

           // You can also return a success response here if needed
           return response()->json(['message' => 'Status updated successfully']);
       }
}
