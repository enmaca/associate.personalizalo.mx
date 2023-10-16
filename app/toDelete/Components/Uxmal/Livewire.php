<?php

namespace App\Components\Uxmal;

use Uxmal;

class Livewire extends Uxmal {

    protected string $path;
    protected mixed $data = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!empty($this->attributes['path'])) {
            $this->path = $this->attributes['path'];
            unset($this->attributes['path']);
        }

        if (!empty($this->attributes['data'])) {
            $this->data = $this->attributes['data'];
            unset($this->attributes['data']);
        }
    }

    public function toArray(): array
    {
        if( empty( $this->path ))
            throw new \Exception("Livewire Uxmal Component Requires [path]");

        return parent::toArray() + [
                'path' => $this->path,
                'data' => $this->data
            ];
    }
}