<?php

namespace App\Support\Workshop\System\Uom;

use App\Models\UnitOfMeasure;
use App\Support\Workshop\Order\Dashboard\Table\TbHandler\OrderIdCheckbox;
use Enmaca\LaravelUxmal\Block\ListJs;

class ListJsUomHome extends ListJs
{
    function build(): void
    {
        $this->_content->setColumns([
            'id' => [
                'tbhContent' => 'checkbox-all',
                'type' => 'primaryKey',
                'handler' => OrderIdCheckbox::class,
            ],
            'name' => [
                'tbhContent' => 'Nombre',
            ],
            'uom_category' => [
                'tbhContent' => 'Categoría',
                'handler' => \App\Support\Workshop\System\Uom\TbHandler\UomCategory::class,
            ],
        ]);

        $this->_content->Model(UnitOfMeasure::class)
            ->select(['id', 'name', 'uom_category']);

        $this->_content->setPagination(10);
        $this->_content->setSearch(true, ['placeholder' => 'Buscar unidad de medida...']);
    }
}