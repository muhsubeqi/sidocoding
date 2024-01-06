<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public $status;
    public $message;
    
    public function __construct($status, $message, $resource) {
        $this->status = $status;
        $this->message = $message;
        parent::__construct($resource);
    }
    public function toArray($request)
    {
        return [
            'status'   => $this->status,
            'message'   => $this->message,
            'data'      => $this->resource
        ];
    }
}