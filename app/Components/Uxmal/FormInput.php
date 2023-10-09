<?php

namespace App\Components\Uxmal;

use Uxmal;

class FormInput extends Uxmal
{
    protected string $label = 'defaultLabel';
    protected string $inputId = 'inputNameId';
    protected string $inputName = 'inputName';
    protected array $labelAttributes = [];
    protected array $inputAttributes = [
        'id' => 'inputNameId',
        'name' => 'inputName',
        'class' => 'form-control'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);


        if (!empty($this->attributes['label'])) {
            $this->label = $this->attributes['label'];
            unset($this->attributes['label']);
        }

        if( !empty($this->attributes['input-attributes']) )
            $this->inputAttributes += $this->attributes['input-attributes'];



        if( !empty($this->inputAttributes['name'])){
            $this->inputName = $this->inputAttributes['name'];
            $this->inputId = $this->inputAttributes['name'].'Id';
            $this->inputAttributes['id'] = $this->inputId;
        }

        if( empty($this->attributes['label-attributes']) ){
            $this->labelAttributes['for'] =  $this->inputId;
            $this->labelAttributes['class'] =  'form-label';
        } else
            $this->labelAttributes += $this->attributes['label-attributes'];

    }

    public function toArray(): array
    {
        return parent::toArray() + [
                'label' => $this->label,
                'label-attributes' => $this->attributesToString($this->labelAttributes),
                'input-attributes' => $this->attributesToString($this->inputAttributes)
            ];
    }
}