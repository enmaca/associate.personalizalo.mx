<?php

namespace App\Support\Enums;

enum MfgCostsEnum: string
{
    case Material = 'catalog_materials';
    case LaborCosts = 'catalog_labor_costs';
    case MfgOverhead = 'catalog_mfg_overhead';
    case MaterialVariationGroup = 'material_variations_group';
    case PrintVariationGroup = 'print_variations_group';

    public function label(): string
    {
        return match ($this) {
            self::Material => 'Material',
            self::LaborCosts => 'Mano de Obra',
            self::MfgOverhead => 'Indirectos',
            self::MaterialVariationGroup => 'Variación de Materiales',
            self::PrintVariationGroup => 'Variación de Impresion'
        };
    }
}
