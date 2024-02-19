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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
                $table->string('name', 150);
                $table->string('contactperson', 100)->nullable();
                $table->string('phone', 100)->nullable();
                // $table->string('phone2', 100)->nullable();
                // $table->string('phone3', 100)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('city', 100)->nullable();
                $table->string('state', 100)->nullable();
                $table->string('address', 200)->nullable();
                $table->string('country',100)->nullable();
                // $table->unsignedBigInteger('createdby')->nullable();
                // $table->unsignedBigInteger('modifiedby')->nullable();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
