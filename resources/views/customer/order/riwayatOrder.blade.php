@extends('customer.master_dashboard')
@section('main')
    @php
        use Illuminate\Support\Facades\Route;
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Facades\Session;
    @endphp

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-container">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kode Pembelian</th>
                                    <th>Nama Produk</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayatPesanan as $order)
                                @foreach ($order->orderItems as $orderItem)
                                    @if ($order->status == 1 || $order->status == 2)
                                        <tr>
                                            <td>#{{ $order->order_id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="recent-product-img">
                                                        <img src="{{ asset('upload/product/' . $orderItem->product->img_product) }}"
                                                            alt="" />
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="mb-1 font-14">{{ $orderItem->product->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>Rp {{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                @php
                                                $statusText = '';
                                                switch ($order->status) {
                                                    case 2:
                                                        $statusText = 'Sudah Diterima';
                                                        break;
                                                    default:
                                                        $statusText = 'Sedang Dikirim ';
                                                }
                                            @endphp
                                            <div class="badge rounded-pill bg-light-info text-info w-150">
                                            <b>{{ $statusText }}</b>
                                            </div>
                                            </td>
                                            <td>
                                                <a href="javascript:;" class="update-status" data-status-type="order" data-order-id="{{ $order->order_id }}" data-toggle="modal" data-target="#updateStatusModal">Konfirmasi Pesanan</a>
                                            </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td>#</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="recent-product-img">
                                                    </div>
                                                    <div class="ms-2">
                                                    </div>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td>

                                                <div class="badge rounded-pill bg-light-info text-info w-150">
                                                </div>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Kode Pembelian</th>
                                    <th>Nama Produk</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>



    </div>
@endsection
