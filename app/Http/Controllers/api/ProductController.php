<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showProducts() {
        $products = Product::all();
        $result = ProductResource::collection($products);

        if ($products->count() > 0) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menampilkan semua produk yang tersedia!',
                'data' => $result
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Tidak ada produk yang tersedia!',
            ], 200);
        }
    }

    public function addProduct(Request $request) {
        $validatedData = $request->validate([
            'nama_produk' => 'required',
            'kategori' => 'required',
            'stock' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validatedData) {
            $product = Product::create($validatedData);
            $result = new ProductResource($product);

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menambahkan produk!',
                'data' => $result
            ], 200);
        } 
    }

    public function updateProduct(Request $request, $id) {
        $product = Product::find($id);

        if ($product) {
            $product->update($request->all());
    
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil mengubah produk!',
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Produk tidak ditemukan!',
            ], 404);
        }

    }

    public function deleteProduct($id) {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
    
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Berhasil menghapus produk!',
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Produk tidak ditemukan!',
            ], 404);
        }

    }
}
