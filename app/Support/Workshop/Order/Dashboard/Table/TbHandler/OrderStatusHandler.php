<?php

namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;
use App\Support\Enums\OrderStatusEnum;
use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;

class OrderStatusHandler extends ColumnParseValue {
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes, OrderStatusEnum::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function parseValue($value): string
    {
        $value = parent::parseValue($value);
        return "<div class='text-center'>".$value ."</div>";
    }
}