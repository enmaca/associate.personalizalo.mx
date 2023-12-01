<?php
namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;

class OrderCustomerHandler extends ColumnParseValue
{

    /**
     * @throws \Exception
     */
    public function parseValue($value): mixed
    {
        if(empty($value))
            return '<div class="text-center">---</div>';

        return '<div class="text-start ms-2">'.$value['name'].' '.$value['last_name'].'<br>'.$value['mobile'].'</div>';
    }
}