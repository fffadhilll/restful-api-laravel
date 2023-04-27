<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCarts() {
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        $result = CartResource::collection($carts);

        if ($carts->count() > 0) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menampilkan semua keranjang yang tersedia!',
                'data' => $result   
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Tidak ada keranjang yang tersedia!',
            ], 200);
        }
    }

    public function addCart(Request $request) {
        $data = $request->all();
        $product = Product::find($data['id']);

        if (!$product) {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Produk tidak ditemukan!'
            ], 404); 
        }

        $id_user = auth()->user()->id;
        $user = Cart::where('user_id', $id_user)->where('id_product',$product->id)->first();

        if($user) {
            $user->jumlah += $data['jumlah'];
            $product->stock = $product->stock - $data['jumlah'];
            $product->save();
            $user->save();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menambahkan keranjang!'
            ], 200);
        }

        if ($product->stock > $data['jumlah']) {
            $cart = Cart::create([
                'id_product' => $data['id'],
                'jumlah' => $data['jumlah'],
                'user_id' => $id_user
            ]);
    
            $product->stock = $product->stock - $data['jumlah'];
            $product->save();
    
            $result = new CartResource($cart);
    
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menambahkan keranjang!',
                'data' => $result
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Stock tidak mencukupi!'
            ], 404); 
        }
    }

    public function deleteCart($id) {
        $cart = Cart::find($id);
        
        if ($cart) {
            $jumlah = $cart->jumlah;
            $cart->products['stock'] += $jumlah;
            $cart->products->save();

            $cart->delete();
    
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menghapus keranjang!',
                'data' => $cart
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Keranjang tidak ditemukan!',
            ], 404);
        }
    }
}
