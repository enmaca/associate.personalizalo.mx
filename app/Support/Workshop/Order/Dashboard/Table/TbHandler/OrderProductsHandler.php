<?php
namespace App\Support\Workshop\Order\Dashboard\Table\TbHandler;

use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Support\Builders\Ui\Table\ColumnParseValue;
use Enmaca\LaravelUxmal\Support\Enums\BootstrapStylesEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonSizeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonTypeEnum;
use Enmaca\LaravelUxmal\Support\Enums\Form\Button\ButtonWidthSizeEnum;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;

class OrderProductsHandler extends ColumnParseValue
{

    /**
     * @throws \Exception
     */
    public function parseValue($value): mixed
    {
        if(empty($value))
            return '<div class="text-center">---</div>';

        $uxmal = new UxmalComponent();

        $button = Button::Options(ButtonOptions::Make()
            ->name('opView@@uniqueId@@')
            ->type(ButtonTypeEnum::Soft)
            ->style(BootstrapStylesEnum::Info)
            ->size(ButtonSizeEnum::Small)
            ->width( ButtonWidthSizeEnum::Small)
            ->appendAttributes([
                'data-row-op-view' => true,
                'data-row-id' => '@@rowId@@'
            ])
            ->label(count($value) . ' Prod.'));

        $uxmal->addRow(RowOptions::Make()
            ->appendAttributes(['class' => 'text-center'])
            ->content($button->toHtml())
        );

        return $uxmal->toHtml();
    }
}