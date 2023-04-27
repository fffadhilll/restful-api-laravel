<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserController extends Controller
{
    use HasApiTokens, HasFactory, Notifiable;
    
    public function createUser(Request $request) {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'alamat' => 'required',
            'password' => 'required|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($validatedData) {
            $user = User::create($validatedData);
            $result = new UserResource($user);

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menambahkan user baru!',
                'data' => $result
            ], 200);
        } 
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (Auth::attempt($credentials)) {        
            $result = new UserResource($user);
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message'=> 'Login berhasil!',
                'data' => [
                    'detail' => $user,
                    'token' => $user->createToken('User Login')->plainTextToken
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => 'Ada yang salah!',
            ], 404);
        }
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'Berhasil logout!',
        ]);
    }

    public function orderDetail($id) {
        $order = Order::where('user_id', auth()->user()->id);
        $order = $order->find($id);
        
        if ($order) {
            $order_detail = OrderDetail::where('order_id', $order->id)->with('products')->get();
            
            return response()->json([
                'status' => true,
                'status_code' => 200,
                'message' => 'Berhasil menampilkan detail dari order dengan '.$id,
                'data' => $order_detail
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'status_code' => 404,
                'message' => 'Pesanan tidak ditemukan',
            ], 404);
        }
    }
}
