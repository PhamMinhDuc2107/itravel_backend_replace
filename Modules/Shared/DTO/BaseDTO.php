<?php
namespace Modules\Shared\DTO;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
abstract class BaseDTO extends Data
{

    public static function fromRequest(Request $request): static
    {
        return static::from($request->all());
    }

    /**
     * update filter optional
     */
    public function toArrayForUpdate(): array
    {
        return array_filter(
            $this->toArray(),
            fn ($value) => !($value instanceof Optional)
        );
    }

    /**
     * create
     */
    public function toArrayForCreate(): array
    {
        return $this->toArray();
    }
}
