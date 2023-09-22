<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        DB::statement('CREATE VIEW v_mex_districts AS SELECT * FROM personalizalo_mx.mex_districts');
        DB::statement('CREATE VIEW v_mex_municipalities AS SELECT * FROM personalizalo_mx.mex_municipalities');
        DB::statement('CREATE VIEW v_mex_states AS SELECT * FROM personalizalo_mx.mex_states');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
