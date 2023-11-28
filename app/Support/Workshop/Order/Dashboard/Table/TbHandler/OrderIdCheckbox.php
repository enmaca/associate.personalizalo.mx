<?php
namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use Enmaca\LaravelUxmal\Components\Form\Input\Checkbox;
use Enmaca\LaravelUxmal\Components\Ui\Listjs\Checkbox as ComponentCheckbox;
use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;
use Enmaca\LaravelUxmal\Support\Options\Form\Input\InputCheckboxOptions;
use Illuminate\Support\Facades\View;

class OrderIdCheckbox extends ColumnParseValue
{

    /**
     * @throws \Exception
     */
    public function parseValue($value): mixed
    {
        $checkboxStruct = Checkbox::Options(new InputCheckboxOptions(
            name: 'order_id',
            label: false,
            value: $value,
            appendAttributes: [
                'data-table-check' => true
            ]
        ));

        return $checkboxStruct->toHtml();
    }
}