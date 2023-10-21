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
                        dump(Product::ProcessMfgPrintVariationGroupCosts($mfg_cost->cost_type_id));
                        break;
                    case 'material_variations_group':
                        dump(Product::ProcessMfgMaterialVariationsGroupCosts($mfg_cost->cost_type_id));
                        break;

                }
                // ProcessMfgMaterialVariationsGroupCosts
            }

        $items = [];
        foreach ($product_data->digital_category->arts as $digital_art)
            $items[] = [
                'slot' => '<img class="image-fluid border rounded mx-auto m-2" src="' . $digital_art->thumbnail_path . '" style="max-width: 100%; max-height: 360px" alt="Image 2" onclick="console.log(\'' . $digital_art->hashId . '\')">'
            ];

        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $main_row = $uxmal->component('ui.row');

        $swiper_name = 'digitalArtSwiper' . $product_data->digital_category->hashId;

        $main_row->component('ui.swiper', [
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

        $this->content = '<div class="row">' . View::make($uxmal->view, [
                'data' => $uxmal->toArray()
            ])->render() . '</div>';


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
