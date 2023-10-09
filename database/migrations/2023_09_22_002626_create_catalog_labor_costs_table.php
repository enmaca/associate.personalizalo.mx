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
        Schema::create('catalog_labor_costs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('name')->fulltext('name');
            $table->float('cost_by_hour', 12, 4);
            $table->integer('min_fraction_cost_in_minutes');
            $table->integer('createdby')->index('createdby');
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
        Schema::dropIfExists('catalog_labor_costs');
    }
};
