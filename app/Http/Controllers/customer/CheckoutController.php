<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class CheckoutController extends Controller
{

    public function checkoutFromProductDetails($product_id)
{

    $product = Product::findOrFail($product_id);
    $relatedProduct = Product::where('product_id', '!=', $product_id)->get();


    return view('customer.checkout.checkout_view', compact('product', 'relatedProduct'));
}



    //endpoint checkout
    public function CheckoutStore(Request $request)
    {
        $newOrder = new Order();
        $newOrder->order_id = Order::generateCustomeId();
        $order_id = $newOrder->order_id;

        $order = Order::create([
            'order_id' => $order_id,
            'user_id' => Auth::id(),
            'status' => 0,
            'total_amount' => $request->total_biaya,
            'notes' => $request->notes
        ]);

        if ($request->hasFile('img_product')) {
            $img_product = $request->file('img_product');
            $nama_gambar = $order->order_id .'-'. date('YmdHis') . '-' . $img_product->getClientOriginalExtension();

            // kompress ukuran file
            $compressedImage = Image::make($img_product)->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($img_product->getClientOriginalExtension(), 75);

            $compressedImage->save('upload/bukti-bayar/' . $nama_gambar);

            // insert data payment
            OrderPayment::insert([
                'order_id' => $order->order_id,
                'payment_method_id' => 1,
                'status_pembayaran' => 0,
                'bukti_bayar' => $nama_gambar,
            ]);
        }

        OrderItem::create([
            'order_id' => $order->order_id,
            'product_id' => $request->prd,
            'quantity' => $request->quantity,
            'price' => $request->total_biaya,
        ]);
        $notification =array(
            'message' =>'Data produk berhasil dihapus',
            'alert-type' =>'success',
        );

        return redirect()->route('dashboard')->with($notification);
    }

}
