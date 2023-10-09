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
        Schema::create('attachmentable', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attachmentable_type');
            $table->unsignedInteger('attachmentable_id');
            $table->unsignedInteger('attachment_id')->index('attachmentable_attachment_id_foreign');

            $table->index(['attachmentable_type', 'attachmentable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachmentable');
    }
};
