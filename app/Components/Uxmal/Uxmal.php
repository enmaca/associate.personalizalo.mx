<?php

namespace App\Components\Uxmal;

class Uxmal implements Renderable {
    protected string $type;
    protected array $children = [];
    protected array $attributes = [];

    public static function make(string $type, array $attributes = []): self {
        $child = new self($type);
        $child->attributes = $attributes;
        $child->children[] = $child;
        return $child;
    }

    protected function __construct(string $type) {
        $this->type = $type;
    }

    public function setAttribute(string $key, $value): void {
        $this->attributes[$key] = $value;
    }

    public function toJson(): string {
        return json_encode($this->toArray());
    }

    public function toArray(): array {
        return [
            'type' => $this->type,
            'attributes' => $this->attributes,
            'children' => array_map(fn($child) => $child->toArray(), $this->children),
        ];
    }

    public function toHtml(): string {
        // Implement based on specific requirements
        return '';
    }
}