<div class="m-3">
@include('uxmal.table.listjs', [
    'table' => [
            'id' => 'orderListJS',
            'listjs' => [
                'attributes' => [
                   "data-listjs-value_names='" .json_encode([
                       'opdd_reference_type',
                       'opdd_reference_id'
                    ])."'"
                ]
            ],
            'header' => [
                'columns' => [
                    [
                        'name' => 'opdd_reference_type',
                        'label' => 'Tipo'
                    ],
                    [
                        'name' => 'opdd_reference_id',
                        'label' => 'Nombre'
                    ],
                    [
                        'name' => 'opdd_quantity',
                        'label' => 'Cantidad'
                    ],
                    [
                        'name' => 'opdd_cost',
                        'label' => 'Costo'
                    ],
                    [
                        'name' => 'opdd_taxes',
                        'label' => 'Impuestos'
                    ],
                    [
                        'name' => 'opdd_profit_margin',
                        'label' => 'Margen'
                    ],
                    [
                        'name' => 'opdd_subtotal',
                        'label' => 'Subtotal'
                    ],
                    [
                        'name' => 'action',
                        'label' => ''
                    ]
                ]
            ],
            'data' => []
    ]])
</div>