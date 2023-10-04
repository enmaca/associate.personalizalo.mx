<?php

namespace App\Components\Uxmal;

class Listjs extends Uxmal {

    protected array $header = [];
    protected array $footer = [];
    protected array $dheader = [];
    protected array $data = [];

    public function setHeader(string $key, $value): void {
        $this->header[$key] = $value;
    }

    public function setData(string $key, $value): void {
        $this->data[$key] = $value;
    }

    public function setDataHeader(string $key, $value): void {
        $this->dheader[$key] = $value;
    }

    public function setFooter(string $key, $value): void {
        $this->footer[$key] = $value;
    }

    public function setAttribute(string $key, $value): void {
        $this->attributes[$key] = $value;
    }

    public function toArray(): array {
        return [
            'type' => $this->type,
            'attributes' => $this->attributes,
            'header' => $this->header,
            'dheader' => $this->dheader,
            'data' => $this->data,
            'footer' => $this->footer,
            'children' => array_map(fn($child) => $child->toArray(), $this->children),
        ];
    }
}