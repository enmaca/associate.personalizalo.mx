<?php

namespace App\Support\UxmalComponents\OrderProductDynamicDetails\TbHandler;
use App\Enums\OrderStatusEnum;
class ProfitMargin extends \Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column {

    public function parseValue(mixed $value): mixed
    {
        $value = parent::parseValue($value);
        if( empty( $value ))
            $value = '0%';
        return "<div>".$value ."</div>";
    }
}