@extends('customer.master_dashboard')
@section('main')

@section('title')
    {{ $product->name }}
@endsection

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> {{ $product->name }}
        </div>
    </div>
</div>
<div class="container mb-30">
    <div class="row">
        <div class="col-xl-10 col-lg-12 m-auto">
            <div class="product-detail accordion-detail">
                <div class="row mb-50 mt-30">
                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                        <div id="productImageCarousel" class="carousel slide" data-ride="carousel">
                            <!-- MAIN SLIDES -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ !empty($product->img_product) ? url('upload/product/' . $product->img_product) : url('upload/no_image.jpg') }}"
                                        class="d-block w-100" alt="Product Image 1" style="max-height: 300px;">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#productImageCarousel" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#productImageCarousel" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!-- THUMBNAILS -->
                        <div class="slider-nav-thumbnails mt-3">
                            <div class="thumbnail-item active">
                                <img src="{{ asset('upload/product/' . $product->img_product) }}" alt="Thumbnail 1"
                                    style="max-width: 100px; max-height: 100px;">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="detail-info pr-30 pl-30">
                            @if ($product->amount > 0)
                                <span class="stock-status in-stock">In Stock </span>
                            @else
                                <span class="stock-status out-stock">Stock Out </span>
                            @endif


                            <h2 class="title-detail" id="dpname"> {{ $product->name }} </h2>
                            <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        <span class="current-price text-brand">Rp {{ $product->price }}</span>
                                    </div>
                            </div>
                            <div class="detail-extralink mb-50">
                                <div class="detail-qty border radius">
                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                    <input type="text" name="quantity" id="dqty" class="qty-val" value="1"
                                        min="1">
                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                </div>
                                <div class="product-extra-link2">

                                    <input type="hidden" id="dproduct_id" value="{{ $product->product_id }}">


                                    <button type="submit" class="button button-add-to-cart"
                                     onclick="addToCheckout()"><i class="fi-rs-shopping-cart"></i>Checkout</button>


                                    {{-- <a aria-label="Add To Wishlist" id="{{ $product->product_id }}"
                                        onclick="addToWishList(this.id)" class="action-btn hover-up"><i
                                            class="fi-rs-heart"></i></a> --}}
                                </div>
                            </div>

                            <hr>

                            <div class="font-xs">
                                <ul class="float-start">
                                    <li>Stock:<span class="in-stock text-brand ml-5">({{ $product->amount }}) Items In
                                            Stock</span></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Detail Info -->
                    </div>
                </div>
            </div>



            <div class="row mt-60">
                <div class="col-12">
                    <h2 class="section-title style-1 mb-30">Related products</h2>
                </div>
                <div class="col-12">
                    <div class="row related-products">


                        @foreach ($relatedProduct as $product)
                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap hover-up">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{ url('product/details/' . $product->product_id . '/' . $product->product_slug) }}"
                                                tabindex="0">
                                                <img class="default-img"
                                                    src="{{ !empty($product->image3) ? url('upload/product/' . $product->image3) : url('upload/no_image.jpg') }}"
                                                    alt="" class="zoom-image" />

                                            </a>
                                        </div>

                                        @php
                                            $amount = $product->price - $product->discount_price;
                                            $discount = ($amount / $product->price) * 100;

                                        @endphp
                                        <div class="product-badges product-badges-position product-badges-mrg">




                                            @if ($product->discount_price == null)
                                                <span class="new">New</span>
                                            @else
                                                <span class="hot"> {{ round($discount) }} %</span>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <h2><a href="shop-product-right.html"
                                                tabindex="0">{{ $product->product_name }}</a></h2>
                                        <div class="rating-result" title="90%">
                                            <span> </span>
                                        </div>

                                        @if ($product->discount_price == null)
                                            <div class="product-price">
                                                <span>${{ $product->price }}</span>

                                            </div>
                                        @else
                                            <div class="product-price">
                                                <span>Rp {{ $product->discount_price }}</span>
                                                <span class="old-price">Rp {{ $product->price }}</span>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
function addToCheckout() {
    var product_id = $("#dproduct_id").val();
    var product_name = $("#dpname").text();
    var product_price = $(".current-price").text().replace('Rp ', '').replace(/\s/g, '');
    var product_quantity = $("#dqty").val();

    // Meneruskan informasi produk ke halaman checkout
    window.location.href = "{{ route('checkout.fromProductDetails', ['product_id' => ':product_id', 'product_name' => ':product_name', 'product_price' => ':product_price', 'product_quantity' => ':product_quantity']) }}"
        .replace(':product_id', product_id)
        .replace(':product_name', product_name)
        .replace(':product_price', product_price)
        .replace(':product_quantity', product_quantity);
}


</script>

@endsection
