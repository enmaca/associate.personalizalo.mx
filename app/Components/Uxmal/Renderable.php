<?php

namespace App\Components\Uxmal;

interface Renderable {
    public function toJson(): string;
    public function toArray(): array;
    public function toHtml(): string;
}