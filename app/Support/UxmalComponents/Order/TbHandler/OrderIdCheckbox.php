<?php
namespace App\Support\UxmalComponents\Order\TbHandler;

use Enmaca\LaravelUxmal\Components\Ui\Listjs\Checkbox as ComponentCheckbox;
use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Checkbox as SupportCheckbox;
use Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column as ColumTable;

use Illuminate\Support\Facades\View;

class OrderIdCheckbox extends ColumTable
{

    /**
     * @throws \Exception
     */
    public function parseValue($value): mixed
    {
        $checkboxStruct = new SupportCheckbox([
            'options' => [
                'listjs.checkbox.id' => $value
            ]
        ]);
        $input_checkbox = new ComponentCheckbox($checkboxStruct->toArray());
        return View::make($input_checkbox->view, [
            'data' => $input_checkbox->toArray()
        ])->render();
    }
}