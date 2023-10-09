<?php

namespace App\Components\Uxmal;

use Renderable;
use Uxmal\Components\Form;
use Uxmal\Components\FormButton;
use Uxmal\Components\FormInput;
use Uxmal\Components\FormSelectChoices;
use Uxmal\Components\FormSelectTomselect;
use Uxmal\Components\Livewire;
use Uxmal\Components\Modal;
use Uxmal\Components\Row;

class Uxmal implements Renderable {
    protected string $type;
    protected array $elements = [];
    protected array $attributes = [];

    /**
     * @throws \Exception
     */
    public function make(string $type, array $attributes = []): object {
        switch( $type ){
            case 'row':
                $child = new Row($attributes);
                break;
            case 'modal':
                $child = new Modal($attributes);
                break;

            /**
             * Forms
             */
            case 'form':
                $child = new Form($attributes);
                break;
            case 'form.button':
                $child = new FormButton($attributes);
                break;
            case 'form.select.choices':
                $child = new FormSelectChoices($attributes);
                break;
            case 'form.select.tomselect':
                $child = new FormSelectTomselect($attributes);
                break;
            case 'form.input':
                $child = new FormInput($attributes);
                break;

            /**
             * Livewire
             */
            case 'livewire':
                $child = new Livewire($attributes);
                break;
            default:
                throw new \Exception("Missing Type [".$type."]");
        }

        $this->elements[] = &$child;
        return $child;
    }

    public function __construct(array $attributes = []) {
        $type_parts = explode("\\", get_class($this));
        $this->type = strtolower($type_parts[(count($type_parts)-2)].'_'.strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $type_parts[(count($type_parts)-1)])));
        $this->attributes = $attributes;

        if(array_key_exists('type', $this->attributes))
            unset($this->attributes['type']);
    }


    public function setAttribute(string $key, $value): void {
        $this->attributes[$key] = $value;
    }

    public function attributesToString($data){
        $_attr = [];
        foreach( $data as $key => $value ){
            if( $value === true) // if the value es = true, onlye the attribute its joint to include without =
                $_attr[] = $key;
            else{
                if(is_array($value))
                    continue;
                $_attr[] = $key.'="'.$value.'"';
            }
        }


        return join(" ", $_attr);
    }

    public function toJson(): string {
        return json_encode($this->toArray());
    }

    public function toArray(): array {

        return [
            'type' => $this->type,
            'attributes' => $this->attributesToString($this->attributes)
        ] + (!empty($this->elements) ? [ 'elements' => array_map(fn($element) => $element->toArray(), $this->elements) ] : []);
    }

    public function toHtml(): string {
        // Implement based on specific requirements
        return '';
    }
}