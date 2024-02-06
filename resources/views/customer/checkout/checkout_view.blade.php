@extends('customer.master_dashboard')
@section('main')
@section('title')
    Checkout Page
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

@endphp

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Checkout
        </div>
    </div>
</div>
<div class="container mb-80 mt-50">
    <div class="row">
        <div class="col-lg-8 mb-40">
            <h3 class="heading-2 mb-10">Checkout</h3>
            <div class="d-flex justify-content-between">
                <h6 class="text-body">Daftar Produk dari Keranjang Belanja Anda</h6>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">

            <div class="row">
                <h4 class="mb-30">Billing Details</h4>
                <form method="post" action="{{ route('checkout.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <h6 class="text-muted">Nama </h6>
                            <input type="text" required="" name="shipping_name" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="form-group col-lg-6">
                            <h6 class="text-muted">Email</h6>
                            <input type="email" required="" name="shipping_email"
                                value="{{ Auth::user()->email }}" readonly>
                        </div>
                    </div>

                    <div class="row shipping_calculator">
                        <div class="form-group col-lg-6">
                            <h6 class="text-muted">No.HP </h6>
                            <input required="" type="text" name="shipping_phone"
                                value="{{ Auth::user()->phone }}" >
                        </div>
                    </div>


                    <div class="row shipping_calculator">

                        <div class="form-group col-lg-6">
                            <h6 class="text-muted">Alamat </h6>
                            <input required="" type="text" name="shipping_address" placeholder="Address *"
                                value="{{ Auth::user()->address }}" readonly>
                        </div>

                        <div class="form-group col-lg-6">
                            <h6 class="text-muted">Upload Bukti Bayar </h6>
                            <input class="form-control" name="img_product" type="file">
                        </div>

                        <div class="form-group col-lg-6">
                            <input required="" type="text" name="notes" placeholder="Masukan Catatan Tambahan" value="">
                        </div>
                    </div>

            </div>
        </div>


        <div class="col-lg-5">
            <div class="border p-40 cart-totals ml-30 mb-50">
                <div class="d-flex align-items-end justify-content-between mb-30">
                    <h4>Your Order</h4>

                </div>
                <div class="divider-2 mb-30"></div>
                <div class="table-responsive order_table checkout">
                    <table class="table no-border">
                        <tbody>
                            <tr>
                                <td class="image product-thumbnail">
                                    @if (!empty($product->img_product))
                                        <img src="{{ asset('upload/product/' . $product->img_product) }}" alt="#"
                                            style="width:50px; height: 50px;">
                                    @else
                                        <img src="{{ asset('upload/no_image.jpg') }}" alt="#"
                                            style="width:50px; height: 50px;">
                                    @endif
                                    <h6 class="w-160 mb-5">{{ $product->name }}</h6>
                                    <input type="hidden" name="quantity" id="quantity"
                                    value="{{ $product->amount }}">
                                    <input type="hidden" name="prd" id="prd"
                                    value="{{ $product->product_id }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table no-border">
                        <tbody>
                            <tr>
                                <td class="cart_total_label">
                                    <h6 class="text-muted">Total Keseluruhan </h6>
                                </td>
                                <td class="cart_total_amount">
                                    <h4 class="text-brand text-end">
                                        {{ $product->price }} </h4>
                                    <input type="hidden" name="total_biaya" id="total_biaya"
                                        value="{{ $product->price }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="payment ml-30">
                <button type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i
                        class="fi-rs-sign-out ml-15"></i></button>
            </div>
        </div>
    </div>
</div>


</form>

@endsection
