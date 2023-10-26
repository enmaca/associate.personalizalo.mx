<?php

namespace App\Support\UxmalComponents\OrderProductDynamicDetails\TbHandler;
use Enmaca\LaravelUxmal\Components\Ui\Listjs\Checkbox as ComponentCheckbox;
use Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\Checkbox as SupportCheckbox;
use Illuminate\Support\Facades\View;

class Id extends \Enmaca\LaravelUxmal\Support\Components\Ui\Listjs\TableColumn {

    /**
     * @throws \Exception
     */
    public function parseValue($value)
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