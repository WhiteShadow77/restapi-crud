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
        $category = [];

        if(!is_null($this?->category_type)){
            $category['type'] = $this->category_type;
        } else {
            if(!is_null($this->category?->type)) {
                $category['type'] = $this->category ?->type;
            }
        }

        if(!is_null($this?->category_name)){
            $category['name'] = $this->category_name;
        } else {
            if(!is_null($this->category?->name)){
                $category['name'] = $this->category?->name;
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => is_null($this->done_at) ? 'IN_PROGRESS' : 'DONE',
            'category' => $category,
            'created at' => $this->created_at,
            'updated at' => $this->updated_at
        ];
    }
}
