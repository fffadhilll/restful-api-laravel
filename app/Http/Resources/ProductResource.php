<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nama_produk" => $this->nama_produk,
            "kategori" => $this->kategori,
            "stock" => $this->stock,
            "deskripsi" => $this->deskripsi,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('LLLL'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('LLLL'),
        ];
    }
}
