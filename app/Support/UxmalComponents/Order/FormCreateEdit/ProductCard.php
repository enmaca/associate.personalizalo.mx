<?php

namespace App\Support\UxmalComponents\Order\FormCreateEdit;

use Illuminate\Support\Str;

class ProductCard extends \Enmaca\LaravelUxmal\Abstract\Card
{

    public function build(): void
    {

        $search_product_tomselect =  \App\Support\UxmalComponents\Products\SelectByName::Object();
        $this->BodyRow();

        $this->BodyInput( $search_product_tomselect);


    }

}