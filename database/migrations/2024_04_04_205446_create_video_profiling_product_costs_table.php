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
        Schema::create('video_profiling_product_costs', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
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
        Schema::dropIfExists('video_profiling_product_costs');
    }
};
