<?php

namespace App\Support\Workshop\Order\TbHandler;
use App\Enums\OrderStatusEnum;
use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column as ColumTable;
class OrderStatus extends ColumTable {
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->enumClass = OrderStatusEnum::class;
        parent::__construct($attributes);
    }

    /**
     * @param $value
     * @return string
     */
    public function parseValue($value): string
    {
        $value = parent::parseValue($value);
        return "<div>".$value ."</div>";
    }
}