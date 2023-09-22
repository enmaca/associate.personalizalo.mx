<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_materials', function (Blueprint $table) {
            $table->integer('id', true);
            $table->tinyText('name')->fulltext('name');
            $table->integer('catalog_tax_id')->index('catalog_tax_id');
            $table->integer('catalog_uom_id')->index('catalog_uom_id');
            $table->integer('invt_quantity')->default(0);
            $table->integer('invt_minimum_stock')->default(0);
            $table->double('invt_uom_cost', 12, 4)->default(0);
            $table->double('invt_total_cost', 12, 4)->default(0);
            $table->double('invt_uom_taxes', 12, 4)->default(0);
            $table->double('invt_total_taxes', 12, 4)->default(0);
            $table->double('invt_uom_landing_cost', 12, 4)->default(0);
            $table->double('invt_total_landing_cost', 12, 4)->default(0);
            $table->decimal('invt_uom_value', 12, 4)->default(0);
            $table->decimal('invt_total_value', 12, 4)->default(0);
            $table->tinyInteger('is_initial_inventory')->default(1)->index('initial_inventory')->comment('Si es igual a 1, el inventario nunca ha sido establecido');
            $table->enum('is_consumable', ['yes', 'no'])->default('no')->index('is_consumable');
            $table->char('opt_color', 6)->nullable()->comment('Color en hexadecimal.');
            $table->tinyText('opt_size')->nullable()->fulltext('opt_size');
            $table->dateTime('created_at')->index('created_at');
            $table->dateTime('updated_at')->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_materials');
    }
};
