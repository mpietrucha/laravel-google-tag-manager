<?php

namespace Mpietrucha\GoogleTagManager;

use Illuminate\Support\Collection;
use Mpietrucha\Support\Concerns\HasFactory;
use Illuminate\Support\Traits\Macroable;

class GoogleTagManager
{
    use HasFactory;
    use Macroable;

    public function __construct(
        protected ?string $id,
        protected bool $enabled,
        protected DataLayer $dataLayer = new DataLayer,
        protected DataLayer $flashDataLayer = new DataLayer,
        protected Collection $pushDataLayer = new Collection
    ){}

    public function id(): ?string
    {
        return $this->id;
    }

    public function enabled(): bool
    {
        return $this->enabled && $this->id;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }

    public function set(): void
    {
        $this->dataLayer->set($key, $value);
    }

    public function dataLayer(): DataLayer
    {
        return $this->dataLayer;
    }

    public function flash(array|string $key, mixed $value = null): void
    {
        $this->flashDataLayer->set($key, $value);
    }

    public function getFlashData(): array
    {
        return $this->flashDataLayer->toArray();
    }

    public function push(array|string $key, mixed $value): void
    {
        $this->pushDataLayer->push(tap(new DataLayer, function (DataLayer $dataLayer) use ($key, $value) {
            $dataLayer->set($key, $value);
        }));
    }

    public function getPushData(): Collection
    {
        return $this->pushDataLayer;
    }

    public function clear(): void
    {
        $this->dataLayer = new DataLayer;
        $this->pushDataLayer = new Collection;
    }

    public function dump(array $data): string
    {
        return with(new DataLayer($data), fn (DataLayer $dataLayer) => $dataLayer->toJson());
    }
}
