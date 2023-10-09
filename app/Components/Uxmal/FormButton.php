<?php

namespace App\Components\Uxmal;

use Uxmal;

class FormButton extends Uxmal
{

    protected string $label = 'defaultLabel';
    protected string $button_type = 'bootstrap';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!empty($this->attributes['label'])) {
            $this->label = $this->attributes['label'];
            unset($this->attributes['label']);
        }

        if (!empty($this->attributes['button-type'])) {
            $this->button_type = $this->attributes['button-type'];
            unset($this->attributes['button-type']);
        }

    }

    public function toArray(): array
    {
        return parent::toArray() + [
                'label' => $this->label,
                'button-type' => $this->button_type
            ];
    }
}