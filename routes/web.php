<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\customer\CheckoutController;
use App\Http\Controllers\customer\HomeController;
use App\Http\Controllers\customer\RiwayatOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'home']); //halaman awal beranda
//route pencarian details product
Route::get('/product/details/{id}', [HomeController::class, 'ProductsDetails'])->name('product.details');

//route untuk login masing-masing user
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->middleware(RedirectIfAuthenticated::class);
Route::get('/customer/login', [HomeController::class, 'CustomerLogin'])->middleware(RedirectIfAuthenticated::class);

//route untuk registrasi user customer
Route::get('/customer/register', [HomeController::class, 'CustomerRegistrasi'])->name('register.customer');


//bagian kelola Produk
Route::controller(ProductController::class)->group(function () {

    Route::get('/admin/produk/all', 'AllProduct')->name('produk.admin');

    Route::get('/admin/produk/tambah', 'AddProduct')->name('tambah.product');
    Route::post('/admin/produk/store', 'ProductInsert')->name('store.product');

    Route::get('/admin/produk/edit/{product_id}', 'EditDataProduct')->name('edit.product');
    Route::post('/admin/produk/update', 'UpdateDataProduct')->name('update.product');

    Route::get('/admin/produk/delete/{product_id}', 'DeleteProduct')->name('delete.product');
});



//membuat group route untuk kelola data order/transaksi
Route::controller(OrderController::class)->group(function () {

    Route::get('/order/product', 'orderCustomer')->name('order.customer');
    //kelola order bagian user Admin
    Route::get('/order/dikirim/admin', 'orderDikirimAdmin')->name('dikirim.admin');
    Route::get('/order/pending/admin', 'pendingOrderAdmin')->name('pending.admin');
    Route::get('/order/selesai/admin', 'orderSelesaiAdmin')->name('selesai.admin');
    Route::get('/order/batal/admin', 'orderCancelAdmin')->name('batal.admin');

    Route::post('/update-order-status/admin', 'updateOrderStatusAdmin')->name('updateStatusOrder.admin');
    Route::post('update-status-bayar/admin', 'updatePaymentStatusAdmin')->name('updateStatusPayment.admin');
});





Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'CustomerDashboard'])->name('dashboard');

    Route::get('/user/logout', [HomeController::class, 'UserLogout'])->name('user.logout');

    //Riwayat order pada user customer
    Route::controller(RiwayatOrderController::class)->group(function () {
        Route::get('/riwayat/order/customer', 'RiwayatOrderCustomer')->name('detailOrder.customer');
        Route::post('/update-order-status', 'updateStatus');
    });
});

//bagian kelola profile
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
});

Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout/from-product-details/{product_id}', 'checkoutFromProductDetails')
        ->name('checkout.fromProductDetails');
    Route::post('/checkout/store', 'CheckoutStore')->name('checkout.store');
});
