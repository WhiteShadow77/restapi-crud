<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResourceCollection extends ResourceCollection
{
private bool $isSuccessfullResponse;
private string $message;
private ?array $keyValueToData;

    public function __construct(bool $isSuccessfullResponse, string $message, $resource, ?array $keyValueToData = null)
    {
        $this->isSuccessfullResponse = $isSuccessfullResponse;
        $this->message = $message;
        $this->keyValueToData = $keyValueToData;
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [
            'status' => $this->isSuccessfullResponse ? 'success' : 'error',
            'message' => $this->message,
        ];

        if (is_null($this->keyValueToData)) {
            $result['data'] = $this->collection;
        } else {
            $result['data'][key($this->keyValueToData)] = current($this->keyValueToData);
            $result['data']['categories'] = $this->collection;
        }

        return $result;
    }
}
