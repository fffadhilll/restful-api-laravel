<?php

namespace App\Http\Controllers\api;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function ubahStatus(Request $request, $id) {
        $order = Order::where('id', $id)->first();
        // dd($order);
        if ($order) {
            $validatedData = $request->validate([
                'status' => [
                    'required',
                    Rule::in(['Diterima', 'Diproses', 'Dikirim', 'Ditolak'])
                ]
            ]);

            if ($validatedData) {
                $order->status = $validatedData['status'];
                $order->save();
    
                return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'Berhasil mengubah status!',
                    'data' => $order
                ], 200);
            } 

        } else {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Pesanan tidak ditemukan!'
            ], 404);
        }
    }
}
