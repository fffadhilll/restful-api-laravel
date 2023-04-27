<?php

namespace App\Http\Controllers\api;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function showOrders() {
        $orders = Order::where('user_id', auth()->user()->id)->get();

        if($orders->count() > 0) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menampilkan semua pesanan!',
                'data' => $orders
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Tidak ada pesanan!'
            ], 200);
        }
    }

    public function addOrder(Request $request) {
        $user = User::find(auth()->user()->id);
        $carts = Cart::where('user_id',$user->id)->get();

        if ($carts->count() > 0) {
            $order = Order::create([
                'user_id' => $user->id
            ]);
    
            if($order){
                foreach ($carts as $cart) {
                    OrderDetail::create([
                        'product_id' => $cart->id_product,
                        'order_id' => $order->id,
                        'jumlah' => $cart->jumlah
                    ]);
                    $cart->delete();
                }

                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'Berhasil menambahkan pesanan!'
                ], 200);
            }
        } else {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Tidak ada keranjang yang tersedia!'
            ], 200);
        }
    }
}
