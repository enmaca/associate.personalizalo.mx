<?php

namespace App\Support\UxmalComponents\OrderProductDetails\TbHandler;

use App\Models\OrderProductDetail;
use Illuminate\Support\Facades\View;

class MfgStatus extends \Enmaca\LaravelUxmal\Support\Components\Ui\Table\Column
{

    /**
     * @throws \Exception
     */
    public function parseValue(mixed $value): mixed
    {
        if (empty($value))
            return '';

        $digital_art = $value['with_digital_art']['digital_art']['preview_path'];
        $print_variation_name = $value['with_digital_art']['print_variation']['display_name'];
        $print_variation_icon = $value['with_digital_art']['print_variation']['preview_path'];
        $material_name = $value['with_digital_art']['material']['name'];
        $html = <<<EOT
<div class="d-flex align-items-center">
    <div class="flex-shrink-0 me-2">
        <img src="{$digital_art}" alt="" class="avatar-lg bg-dark-subtle rounded">
    </div>
    <div class="flex-grow-1 align-items-center" style="flex-direction: column">
    <div class="m-1">{$material_name}</div>
    <div class="m-1">$print_variation_name <img src="{$print_variation_icon}" alt="" class="avatar-sm rounded"></div>
    </div>
</div>
EOT;

        return $html;
    }
}