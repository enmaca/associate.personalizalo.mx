<?php

namespace App\Support\Workshop\Order\TbHandler;

use App\Enums\OrderPaymentStatusEnum;
use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column as ColumTable;

class OrderPaymentStatus extends ColumTable
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->enumClass = OrderPaymentStatusEnum::class;
        parent::__construct($attributes);
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