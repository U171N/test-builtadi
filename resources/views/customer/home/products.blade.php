@php
    $products = App\Models\Product::orderBy('product_id', 'ASC')
        ->limit(10)
        ->get();
@endphp

<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3> New Products </h3>
            <ul class="nav nav-tabs links" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="nav-tab-one" data-bs-toggle="tab" data-bs-target="#tab-one"
                        type="button" role="tab" aria-controls="tab-one" aria-selected="true">All</button>
                </li>
            </ul>
        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">

                    @foreach ($products as $product)
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                data-wow-delay=".1s">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a
                                            href="{{ route('product.details', ['id' => $product->product_id, 'name' => $product->name]) }}
                    ">
                                            <img class="default-img"
                                                src="{{ asset('upload/product/' . $product->img_product) }}" />
                                        </a>
                                    </div>
                                </div>
                                <div class="product-content-wrap">

                                    <h2><a
                                            href="{{ route('product.details', ['id' => $product->product_id, 'name' => $product->name]) }}
                ">
                                            {{ $product->name }} </a></h2>
                                </div>
                            </div>
                        </div>
                        <!--end product card-->
                    @endforeach




                </div>
                <!--End product-grid-4-->
            </div>
            <!--En tab one-->


        </div>
        <!--End tab-content-->
    </div>
</section>
