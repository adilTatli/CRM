<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'file_path' => $this->file_path,
            'file_name' => $this->file_name,
            'file_note' => $this->file_note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
