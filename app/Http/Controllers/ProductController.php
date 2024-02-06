<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
class ProductController extends Controller
{
    //function untuk menampilkan semua data product
    public function AllProduct() {
        $products = Product::latest()->get();
        return view('admin.product.product_all',compact('products'));
    }

    //function untuk menampilkan halaman tambah data product
    public function AddProduct(){
        $products = Product::latest()->get();

        return view('admin.product.product_add',compact('products'));
    }

    //function untuk melakukan insert data product
    public function ProductInsert(Request $request){
        $newProduct = new Product();
        $newProduct->product_id = Product::generateCustomeId();

        $product_id =$newProduct->product_id;

        //generate data image product
        $img_product= $request->file('img_product');
        $nama_gambar =$product_id.date('YmdHis').'-'.$img_product->getClientOriginalExtension();
        Image::make($img_product)->resize(120,120)->save('upload/product/'.$nama_gambar);
        $save_gambar= 'upload/product/'.$nama_gambar;

        Product::insert([
            'product_id'=>$newProduct->product_id,
            'name'=>$request->product_name,
            'description'=>$request->description,
            'price'=>$request->price,
            'img_product'=>$nama_gambar,
            'amount'=>$request->stock
        ]);
        $notification = array(
            'message'=>'product baru berhasil ditambahkan',
            'alert-type'=>'success',
        );
        return redirect()->route('produk.admin')->with($notification);
    }


    //function untuk menampilkan halaman edit data product
    public function EditDataProduct($product_id){
        $products=Product::findOrFail($product_id);
        //get data product semua nya berdasarkan id product yang dipilih
        $products=Product::latest()->get();

        return view('admin.product.product_edit',compact($products));
    }

    //function untuk melakukan update data product
    public function UpdateDataProduct(Request $request){
        $existingProducts=Product::find($request->product_id);
        $existingProducts->name =$request->product_name;
        $existingProducts->description =$request->description;
        $existingProducts->price =$request->price;
        $existingProducts->amount =$request->amount;

        //update data gambar product
        if($request->hasFile('img_product')){
            $gambar= $request->file('img_product');
            $nama_gambar=$existingProducts->product_id.date('YmdHis').$gambar->getClientOriginalExtension();
            Image::make($gambar)->resize(120,120)->save('upload/product/'.$nama_gambar);
            $existingProducts->img_product=$nama_gambar;
        }
        $existingProducts->save();

        $notification = array(
            'message'=>'Produk berhasil diupdate',
            'alert-type'=>'success',
        );

        return redirect()->route('produk.admin')->with($notification);
    }
    //endpoint untuk hapus data product
    public function DeleteProduct($product_id){
        $product =Product::findOrFail($product_id);
        Product::findOrFail($product_id)->delete();

        $notification =array(
            'message' =>'Data produk berhasil dihapus',
            'alert-type' =>'success',
        );

        return redirect()->route('produk.admin')->with($notification);
    }
}
