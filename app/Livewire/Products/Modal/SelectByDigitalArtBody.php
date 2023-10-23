<?php

namespace App\Livewire\Products\Modal;

use App\Models\DigitalArt;
use App\Models\Product;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\Attributes\On;

class SelectByDigitalArtBody extends Component
{
    public $content;

    public function mount()
    {
        $this->content = 'Initial Content';
    }

    #[On('select-by-digital-art-body::product.changed')]
    public function product_changed($product): void
    {

        $product_data = Product::With([
            'digital_category.arts',
            'mfg_costs'])->findByHashId($product); //

        if (!empty($product_data->mfg_costs))
            foreach ($product_data->mfg_costs as $mfg_cost) {
                switch ($mfg_cost->cost_type) {
                    case 'print_variations_group':
                        $pvg_data = Product::ProcessMfgPrintVariationGroupCosts($mfg_cost->cost_type_id);
                        break;
                    case 'material_variations_group':
                        $mvg_data = Product::ProcessMfgMaterialVariationsGroupCosts($mfg_cost->cost_type_id);
                        break;

                }
                // ProcessMfgMaterialVariationsGroupCosts
            }

        $items = [];
        foreach ($product_data->digital_category->arts as $digital_art) {
            $slot = <<<END
    <div>
        <div class="bg-dark-subtle rounded">
            <img class="image-fluid mx-auto m-2" src="{$digital_art->thumbnail_path}" style="max-width: 100%; max-height: 340px" alt="Image 2">
        </div>
        <div class="pt-3">
            <a href="#!"  onclick="console.log('{$digital_art->hashId}')" class="stretched-link">
                <h6 class="fs-15 lh-base text-truncate mb-0"></h6>
            </a>
        </div>
    </div>
END;
            $items[] = [
                'slot' => $slot
            ];
        }

        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $digital_art_swiper_row = $uxmal->component('ui.row');

        $swiper_name = 'digitalArtSwiper' . $product_data->digital_category->hashId;

        $digital_art_swiper_row->component('ui.swiper', [
            'options' => [
                'swiper.name' => $swiper_name,
                'swiper.items' => $items,
                'swiper.config.slides-per-view' => 4,
                'swiper.config.grid.rows' => 1,
                'swiper.config.space-between' => 10,
                'swiper.config.pagination' => 'progress',
                'swiper.config.navigation' => true
            ]
        ]);

        /**
         * Print Variation Groud Data
         */
        if (!empty($pvg_data['items'])) {
            $__pvg_html = <<<EOT
        <div class="col-12">
            <hr style="border-color: #bbb;background-color: #bbb;">
        </div>
        <label class="mb-1 d-block">{$pvg_data['name']}</label>
        <div class="print-variant">
EOT;
            $__pvg_count = 0;
            foreach ($pvg_data['items'] as $pvg_item) {
                $__pvg_count++;
                $pvg_checked = '';
                if ($__pvg_count == 1)
                    $pvg_checked = 'checked';
                $pvg_total = $pvg_item['price'] + $pvg_item['taxes'];
                $__pvg_html .= <<<EOT
        <input data-pvg-id="{$pvg_item['hashId']}" id="pvg_{$pvg_item['hashId']}Id" type="radio" class="btn-check d-none" name="{$pvg_data['hashId']}" value="{$pvg_item['hashId']}" autocomplete="off" {$pvg_checked}>
        <label for="pvg_{$pvg_item['hashId']}Id" class="btn btn-outline-light w-100 d-flex align-items-center border rounded">
            <img data-pvgd-id="{$pvg_item['hashId']}" src="{$pvg_item['preview_path']}" alt="{$pvg_item['display_name']}" width="70">
            <div class="ms-2 small d-flex flex-column justify-content-center align-items-start">
                <b>{$pvg_item['display_name']}</b>
                <span class="text-muted">\${$pvg_total}</span>
            </div>
        </label>
EOT;
            }
            $__pvg_html .= '</div>';
            $uxmal->component('ui.row', ['options' => [
                'row.slot' => $__pvg_html
            ]]);

        }

        if (!empty($mvg_data['variations'])) {
            $__mvg_data = '';
            foreach ($mvg_data['variations'] as $variation_type => $variation_data) {
                $__mvg_data .= <<<EOT
                <div class="col-12">
                    <hr style="border-color: #bbb;background-color: #bbb;">
                </div>
EOT;
                switch ($variation_type) {
                    case 'color':
                        $__mvg_data .='<label class="mb-1 d-block">Color:</label>';
                        $__mvg_data .='<div class="d-flex flex-wrap color-variant">';
                        foreach ($variation_data as $color)
                            $__mvg_data .= <<<EOT
                            <input data-mvg-color="{$color}" class="d-none" id="{$color}Id" name="mvg_{$mvg_data['hashId']}_selected" type="radio" value="{$color}"\>
                            <label for="{$color}Id" class="me-2 mb-2 rounded" style="padding: 1px;">
                                <div class="pa-1 w-100 h-100" style="background-color: #{$color}; border-radius: 4px"></div>
                            </label>
EOT;
                        $__mvg_data .= '</div>';
                        break;
                    case 'size':
                        $__mvg_data .= '<label class="mb-1 d-block">Tamaño:</label>';
                        $__mvg_data .= '<div class="d-flex justify-content-between size-variant">';
                        foreach ($variation_data as $size)
                            $__mvg_data .= <<<EOT
                            <input data-mvg-size="{$size}" class="d-none" id="{$size}Id" name="mvg_{$mvg_data['hashId']}_selected" type="radio" value="{$size}">
                            <label for="{$size}Id" class="btn btn-sm btn-outline-dark flex-grow-1 mx-1">{$size}</label>
EOT;

                        $__mvg_data .= '</div>';
                        break;
                }
            }

            $uxmal->component('ui.row', ['options' => [
                'row.slot' => $__mvg_data
            ]]);
        }

        $this->content = View::make($uxmal->view, [
                'data' => $uxmal->toArray()
            ])->render();


        $this->dispatch('select-by-digital-art-body::showmodal', swiperName: $swiper_name);
    }


    public function render()
    {


        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();
        $uxmal->component('ui.row', [
            'options' => [
                'row.append-attributes' => [
                    'wire:model' => 'content'
                ],
                'row.slot' => $this->content
            ],
        ]);


        return view('uxmal::livewire', ['data' => $uxmal->toArray()]);
    }

}
