<?php

namespace App\Http\Resources;

use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @property CarbonInterface $resource
 */
class DateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'human' => $this->resource->diffForHumans(),
            'string' => $this->resource->toIso8601String(),
            'timestamp' => $this->resource->timestamp,
        ];
    }
}
