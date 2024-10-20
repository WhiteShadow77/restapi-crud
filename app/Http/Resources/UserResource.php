<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if(isset($this->email)){
            $result = ['email' => $this->email];
        }

        if(!isset($this->task_quantity)) {
            $result['tasks quantity'] = count($this->tasks);
        } else {
            if(isset($this->category_name)) {
                $result['name'] = $this->category_name;
            }
            if(isset($this->user_email)) {
                $result['email'] = $this->user_email;
            }
            $result['tasks quantity'] = $this->task_quantity;
        }
        return $result;
    }
}
