<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudenParentResource extends JsonResource
{
    public $status;
    public $code;
    public $message;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function __construct($status, $code,  $message, $resource) 
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
    }

    public function toArray(Request $request): array
    {
        return [
            'success' => $this->status,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }
}
