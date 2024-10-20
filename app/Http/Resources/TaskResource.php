<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'status' => is_null($this->done_at) ? 'IN_PROGRESS' : 'DONE',
            'category' => [
                'type' => !is_null($this?->category_type) ? $this->category_type : $this->category->type,
                'name' => !is_null($this?->category_name) ? $this->category_name : $this->category->name,
            ],
            'created at' => $this->created_at,
            'updated at' => $this->updated_at
        ];
    }
}
