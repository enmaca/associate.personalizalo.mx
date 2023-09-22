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
        Schema::create('aws_requests_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aws_request_id', 64);
            $table->longText('log');
            $table->dateTime('created_at')->useCurrent()->index('created_at');
            $table->dateTime('updated_at')->useCurrent()->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aws_requests_log');
    }
};
