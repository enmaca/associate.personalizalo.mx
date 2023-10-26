<?php

namespace App\Support\UxmalComponents\System\Uom\TbHandler;

use App\Enums\UnitOfMeasureCategoryEnum;
use Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn;

class UomCategory extends TableColumn
{
    public function __construct($attributes = [])
    {
        $this->enumClass = UnitOfMeasureCategoryEnum::class;
        parent::__construct($attributes);
    }

    public function parseValue($value): string
    {
        $value = parent::parseValue($value);
        return "<div>{$value}</div>";
    }
}