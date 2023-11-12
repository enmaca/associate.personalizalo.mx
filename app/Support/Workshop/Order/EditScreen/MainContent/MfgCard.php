<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\MfgArea\SelectByName as SelectByNameMfgArea;
use App\Support\Workshop\MfgDevices\SelectByName as SelectByNameMfgDevices;
use Enmaca\LaravelUxmal\Abstract\CardBlock;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Exception;

class MfgCard extends CardBlock
{
    /**
     * @throws Exception
     */
    public function build(): void
    {
        $this->NewBodyRow();

        $this->BodyRow()->addElementInRow(
            element: SelectByNameMfgArea::Object(),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));

        $this->BodyRow()->addElementInRow(
            element: SelectByNameMfgDevices::Object(),
            row_options: new RowOptions(
                replaceAttributes: [
                    'class' => 'col-xxl-6 mb-3'
                ]
            ));
    }
}