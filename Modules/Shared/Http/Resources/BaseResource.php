<?php

namespace Modules\Shared\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    protected function data(Request $request): array
    {
        return parent::toArray($request);
    }

    protected function meta(): array
    {
        return [
            'app'     => config('api.name'),
            'version' => config('app.version'),
            'time'    => now()->toIso8601String(),
        ];
    }

    public function toArray($request): array
    {
        return [
            'data' => $this->data($request),
            'meta' => $this->meta(),
        ];
    }
}
