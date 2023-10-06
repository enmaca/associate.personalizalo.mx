<?php

namespace App\Components\Uxmal;

class Modal extends Uxmal {

    protected Uxmal $header;
    protected Uxmal $body;
    protected Uxmal $footer;
    protected string $modalType;

    protected string $headerLabel = 'headerLabel';

    /**
     * @throws \Exception
     */
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        /**
         * Header Construct
         */
        if( !empty( $this->attributes['header']))
            $this->setModalAttribute('header');

        /**
         * Body Construct
         */
        if( !empty( $this->attributes['body']))
            $this->setModalAttribute('body');


        /**
         * Footer Construct
         */
        if( !empty( $this->attributes['footer']))
            $this->setModalAttribute('footer');

        $this->modalType = 'bootstrap';
        if( !empty($this->attributes['modal-type'])){
            $this->modalType = $this->attributes['modal-type'];
            unset($this->attributes['modal-type']);
        }



    }

    /**
     * @throws \Exception
     */
    public function setModalAttribute(string $type): void
    {
        $data = $this->attributes[$type];
        unset($this->attributes[$type]);
        if(is_object($data)){
            $obj = &$data;
        } else if ( is_array($data)){
            $_elements = [];
            if( !empty( $data['elements'] )){
                $_elements = $data['elements'];
                unset($data['elements']);
            }

            $_attributes = [];
            if( !empty( $data )) {
                $_attributes = $data;
                unset($data);
            }

            if( $type == 'header' && isset($_attributes['label']))
                $this->headerLabel = $_attributes['label'];

            $obj = new Uxmal($_attributes);
            foreach( $_elements  as $body_element_idx => $_element )
                $obj->make(array_key_first($_element), $_element[array_key_first($_element)]);
        }

        switch( $type ){
            case 'header':
                $this->header = &$obj;
                break;
            case 'body':
                $this->body = &$obj;
                break;
            case 'footer':
                $this->footer = &$obj;
                break;
        }

    }
    public function setAttribute(string $key, $value): void {
        $this->attributes[$key] = $value;
    }

    public function toArray(): array {
        return parent::toArray() + [
                'modal-type' => $this->modalType,
                'header' => $this->header->toArray(),
                'header-label' => $this->headerLabel,
                'body' => $this->body->toArray(),
                'footer' => $this->footer->toArray(),
            ];
    }
}