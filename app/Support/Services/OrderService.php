<?php

namespace App\Support\Services;

use App\Models\DigitalArt;
use App\Models\MaterialVariationsGroup;
use App\Models\MaterialVariationsGroupDetails;
use App\Models\OrderProductDetail;
use App\Models\OrderProductDetailsDigitalArt;
use App\Models\PrintVariationsGroupDetails;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class OrderService
{
    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public static function addProductWithDigitalArt($data): mixed
    {
        $validatedData = validator($data, [
            'mvg_id' => 'integer',
            'mvg_selected_color' => 'string',
            'mvg_selected_size' => 'string',
            'print_variation_group_id' => 'integer',
            'print_variation_group_detail_id' => 'integer',
            'digital_art_category_id' => 'required|integer',
            'digital_art_id' => 'required|integer',
            'order_id' => 'required|integer',
            'catalog_product_id' => 'required|integer',
            'quantity' => 'required|integer'
        ])->validate();

        $product_data = Product::with(['taxes', 'mfg_costs.related'])->findOrFail($data['catalog_product_id'])->toArray();
        $mvg = MaterialVariationsGroup::findOrFail($data['mvg_id']);
        $digital_art_data = DigitalArt::with(['category'])->findOrFail($data['digital_art_id'])->toArray();

        /*******************
         * Caculate Price  *
         *******************/
        $tax_percentage = 0;
        foreach ($product_data['taxes'] as $tax_data)
            $tax_percentage += $tax_data['value'];

        /******************
         * Estimated Cost *
         ******************/
        $unit_cost = 0;
        foreach ($product_data['mfg_costs'] as $_mfg_cost) {
            switch ($_mfg_cost['cost_type']) {
                case 'catalog_materials':
                    $unit_cost += $_mfg_cost['related']['invt_uom_cost'];
                    break;
                case 'catalog_labor_costs':
                    $_qty = $_mfg_cost['quantity'];
                    $_labor_cost_by_minute = (float)$_mfg_cost['related']['cost_by_hour'] / 60;
                    $_min_fraction = (integer)$_mfg_cost['related']['min_fraction_cost_in_minutes'];
                    if ($_qty <= $_min_fraction)
                        $unit_cost += ($_min_fraction * $_labor_cost_by_minute);
                    else
                        $unit_cost += ($_qty * $_labor_cost_by_minute);
                    break;
                case 'mfg_overhead':
                    $unit_cost += $_mfg_cost['related']['value'];
                    break;
                case 'material_variations_group':
                    $mvgd = MaterialVariationsGroupDetails::with(['material'])->where('mvg_id', $data['mvg_id'])->get();
                    $material = null;
                    foreach ($mvgd->toArray() as $_material)
                        if ($_material['material']['opt_size'] == $data['mvg_selected_size'] && $_material['material']['opt_color'] == $data['mvg_selected_color'])
                            $material = $_material['material'];

                    if (empty($material))
                        throw new \Exception("El Material con color {$data['mvg_selected_color']} y talla {$data['mvg_selected_size']} no existe en el Grupo de Materiales {{$mvg->name}}!");

                    $unit_cost += $material['invt_uom_cost'];
                    break;
                case 'print_variations_group':
                    $pvgd_data = PrintVariationsGroupDetails::findOrFail($data['print_variation_group_detail_id'])->toArray();
                    if (empty($pvgd_data))
                        throw new \Exception("La variación de impresion contiene un error para el producto {$data['catalog_product_id']}!");
                    $unit_cost += $pvgd_data['price'];
                    break;
            }
        }


        $unit_subtotal = 0;
        switch ($product_data['price_type']) { // 'calculated',,'fixed_by_pvg'
            case 'calculated':
                $unit_subtotal = $unit_cost * (1 + (float)$product_data['profit_margin']);
                break;
            case 'fixed_by_product':
                $unit_subtotal = (float)$product_data['price'];
                break;
            case 'fixed_by_pvg':
                $pvgd_data = PrintVariationsGroupDetails::findOrFail($data['print_variation_group_detail_id'])->toArray();
                if (empty($pvgd_data))
                    throw new \Exception("La variación de impresion contiene un error para el producto {$data['catalog_product_id']}!");
                $unit_subtotal += $pvgd_data['price'];
                break;

        }

        $unit_taxes = $unit_subtotal * $tax_percentage;
        $unit_price = $unit_subtotal + $unit_taxes;

        $profit_margin = 0;
        if ($unit_price != 0)
            $profit_margin = round(($unit_subtotal - $unit_cost) / $unit_cost, 2);

        $cost = $unit_cost * $data['quantity'];
        $price = $unit_price * $data['quantity'];
        $taxes = $unit_taxes * $data['quantity'];
        $subtotal = $unit_subtotal * $data['quantity'];

        /***********************
         * OrderProductDetails *
         ***********************/

        /**
         * `order_id` int NOT NULL,
         * `catalog_product_id` int NOT NULL,
         * `quantity` int NOT NULL,
         * `subtotal` decimal(12,4) NOT NULL DEFAULT '0.0000',
         * `price` decimal(12,4) DEFAULT NULL,
         * `taxes` decimal(12,4) DEFAULT NULL,
         * `estimated_cost` decimal(12,4) DEFAULT NULL,
         * `profit_margin` float(3,3) DEFAULT NULL,
         * `mfg_preview_image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
         * `mfg_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
         * `mfg_status` enum('not_needed','working','ready','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'not_needed',
         * `mfg_device_id` int DEFAULT NULL,
         * `mfg_status_ready_at` datetime DEFAULT NULL,
         * `mfg_status_ready_by` int DEFAULT NULL,
         * `mfg_media_id_needed` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'no',
         * `mfg_media_id_exists` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'no',
         * `mfg_media_id_exists_at` datetime DEFAULT NULL,
         * `created_by` int DEFAULT NULL,
         * `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
         * `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
         */

        $order_product_detail_arr = [
            'order_id' => $data['order_id'],
            'catalog_product_id' => $data['catalog_product_id'],
            'quantity' => $data['quantity'],
            'unit_cost' => $unit_cost,
            'unit_taxes' => $unit_taxes,
            'unit_profit' => $unit_price - $unit_cost,
            'unit_price' => $unit_price,
            'unit_subtotal' => $unit_subtotal,
            'cost' => $cost,
            'taxes' => $taxes,
            'profit' => $price - $cost,
            'price' => $price,
            'subtotal' => $subtotal,
            'profit_margin' => $profit_margin,
            'mfg_media_id_needed' => 'yes',
            'mfg_media_id_exists' => 'no',
            'created_by' => Auth::id(),
        ];

        $order_product_detail = OrderProductDetail::create($order_product_detail_arr);

        /**
         * OrderProductDetailsDigitalArt
         *
         * `opd_id` int NOT NULL,
         * `mvg_selected_color` int NOT NULL,
         * `mvg_selected_size` int NOT NULL,
         * `mvg_id` int NOT NULL,
         * `digital_art_category_id` int NOT NULL,
         * `digital_art_id` int NOT NULL,
         * `print_variation_group_id` int NOT NULL,
         * `print_variation_group_detail_id` int NOT NULL,
         * `material_id` int NOT NULL,
         *
         */

        $order_product_detail_digital_art_arr = [
            'opd_id' => $order_product_detail->id,
            'mvg_selected_color' => $data['mvg_selected_color'],
            'mvg_selected_size' => $data['mvg_selected_size'],
            'mvg_id' => $data['mvg_id'],
            'digital_art_category_id' => $data['digital_art_category_id'],
            'digital_art_id' => $data['digital_art_id'],
            'print_variation_group_id' => $data['print_variation_group_id'],
            'print_variation_group_detail_id' => $data['print_variation_group_detail_id'],
            'material_id' => $material['id']
        ];


        $order_product_detail_digital_art = OrderProductDetailsDigitalArt::create($order_product_detail_digital_art_arr);

        return $order_product_detail->toArray() + ['with_digital_art' => $order_product_detail_digital_art->toArray()];
    }


}