<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('LLLL'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('LLLL'),
        ];
    }
}
