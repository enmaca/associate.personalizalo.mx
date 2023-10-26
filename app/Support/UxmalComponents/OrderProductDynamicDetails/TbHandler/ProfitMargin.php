<?php

namespace App\Support\UxmalComponents\OrderProductDynamicDetails\TbHandler;
use App\Enums\OrderStatusEnum;
class ProfitMargin extends \Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn {

    public function parseValue($value){
        $value = parent::parseValue($value);
        if( empty( $value ))
            $value = '0%';
        return "<div>".$value ."</div>";
    }
}