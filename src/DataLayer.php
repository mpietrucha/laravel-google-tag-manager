<?php

namespace Mpietrucha\GoogleTagManager;

use Illuminate\Support\Arr;
use Mpietrucha\Support\Types;
use Mpietrucha\Support\Json;

class DataLayer
{
    public function __construct(protected array $data = [])
    {
    }

    public function set(string|array $key, mixed $value = null): void
    {
        if (Types::array($key)) {
            collect($key)->each(fn (mixed $value, string $key) => $this->set($key, $value));

            return;
        }

        Arr::set($this->data, $key, $value);
    }

    public function clear(): void
    {
        $this->data = [];
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function toJson(): string
    {
        return Json::encode($this->data);
    }
}
