<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskResourceCollection extends ResourceCollection
{
    private bool $isSuccessfullResponse;
    private string $message;

    public function __construct(bool $isSuccessfullResponse, string $message, $resource)
    {
        $this->isSuccessfullResponse = $isSuccessfullResponse;
        $this->message = $message;
        parent::__construct($resource);
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->isSuccessfullResponse ? 'success' : 'error',
            'message' => $this->message,
            'data' => $this->collection,

        ];
    }
}
