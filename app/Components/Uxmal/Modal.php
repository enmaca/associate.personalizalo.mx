<?php

namespace App\Components\Uxmal;

class Modal extends Uxmal {

    protected array $header = [];
    protected array $body = [];
    protected array $footer = [];

    public function setHeader(string $key, $value): void {
        $this->header[$key] = $value;
    }

    public function setBody(string $key, $value): void {
        $this->body[$key] = $value;
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
            'body' => $this->body,
            'footer' => $this->footer,
            'children' => array_map(fn($child) => $child->toArray(), $this->children),
        ];
    }
}