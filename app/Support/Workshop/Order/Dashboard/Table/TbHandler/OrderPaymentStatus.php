<?php

namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use App\Support\Enums\OrderPaymentStatusEnum;
use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;

class OrderPaymentStatus extends ColumnParseValue
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes, OrderPaymentStatusEnum::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function parseValue($value): string
    {
        $value = parent::parseValue($value);
        return "<div>" . $value . "</div>";
    }
}