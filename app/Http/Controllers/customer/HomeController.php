<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //menampilkan halaman dashboard untuk user customer yang sudah login
    public function CustomerDashboard(){
      $id = Auth::user()->id;
      $userData = User::find($id);
      return view('index',compact('userData'));
  }


    //endpoint untuk menampilkan data pada halaman beranda customer
    public function Home(){
        $products = Product::latest()->get();
        return view('customer/index',compact('products'));
    }

    //menampilkan halaman registrasi customer
    public function CustomerRegistrasi(){
        return view('auth.register');
      }
      //menampilkan halaman login customer
      public function CustomerLogin(){
        return view('auth/login');
      }

      //endpoint untuk menampilkan detail data product pada halaman beranda
      public function ProductsDetails($id){
        $product = Product::findOrFail($id);
        $relatedProduct = Product::where('product_id','!=',$id)->orderBy('product_id','DESC')->limit(4)->get();

        return view('customer.home.product_details',compact('product','relatedProduct'));
      }

       //endpoint user customer logout
    public function UserLogout(Request $request){
      Auth::guard('web')->logout();

      $request->session()->invalidate();

      $request->session()->regenerateToken();

      $notification= array(
          'message'=>'User berhasil logout',
          'alert-type'=>'success',
      );

      return redirect('/login')->with($notification);
  }
}
