<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_product' => $this->id_product,
            'user_id' => $this->user_id,
            'jumlah' => $this->jumlah,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('LLLL'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('LLLL'),
        ];
    }
}
