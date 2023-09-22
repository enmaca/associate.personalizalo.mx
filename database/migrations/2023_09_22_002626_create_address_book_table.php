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
        Schema::create('address_book', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('customer_id')->nullable()->index('customer_id');
            $table->string('name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('contact_mobile', 15)->nullable();
            $table->string('address_1', 100)->nullable();
            $table->string('address_2', 100)->nullable();
            $table->string('zip_code', 16);
            $table->integer('municipalities_id')->index('municipalities_id');
            $table->integer('states_id')->index('satates_id');
            $table->integer('district_id')->nullable();
            $table->char('country_code', 3)->default('MEX')->index('country_code')->comment('ALPHA-3 country codes https://www.iban.com/country-codes');
            $table->string('directions')->nullable();
            $table->enum('type_id', ['hospital', 'house', 'school', 'office', 'apartment', 'other'])->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->boolean('active')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_book');
    }
};
