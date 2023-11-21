<?php

namespace App\Support\Enums;

/**
 * 'na','material_mockup','material_select','product_individual','product_group','product_lifestyle','product_scale','product_detailed','product_packaging', 'customer_reference'
 */
enum MediaReferenceTypeEnum: string
{
    /** NA */
    case NA = 'na';

    /** Material */
    case MaterialMockup = 'material_mockup';
    case MaterialSelect = 'material_select';

    /** Product */
    case ProductIndividual = 'product_individual';
    case ProductGroup = 'product_group';
    case ProductLifestyle = 'product_lifestyle';
    case ProductScale = 'product_scale';
    case ProductDetailed = 'product_detailed';
    case ProductPackaging = 'product_packaging';

    /** Order Product \\ Dynamic */
    case CustomerReference = 'customer_reference';

    public function label(): string
    {
        return match ($this) {
            self::NA => 'NA',
            self::MaterialMockup => 'Mockup de material',
            self::MaterialSelect => 'Selección de material',
            self::ProductIndividual => 'Producto individual',
            self::ProductGroup => 'Grupo de productos',
            self::ProductLifestyle => 'Lifestyle de producto',
            self::ProductScale => 'Escala de producto',
            self::ProductDetailed => 'Detalle de producto',
            self::ProductPackaging => 'Empaque de producto',
            self::CustomerReference => 'Referencia de cliente',
        };
    }
}