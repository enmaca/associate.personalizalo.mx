<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Material;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MaterialFixTaxes extends Command
{
    protected $signature = 'personalizalo:material_fix_taxes';  // The command signature
    protected $description = 'A description of your command';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $material_data = Material::with('taxes')->get()->toArray();
        foreach( $material_data as $material ){
            $materialRow = Material::find($material['id']);
            //'mfg_overhead','catalog_products','catalog_materials'
            $materialRow->taxes()->syncWithoutDetaching(1);

            $materialRow->invt_uom_taxes = $material['invt_uom_cost'] * .16;
            $materialRow->invt_total_taxes = ($material['invt_uom_cost'] * .16) * $material['invt_quantity'];
            $materialRow->save();
        }

    }
}
