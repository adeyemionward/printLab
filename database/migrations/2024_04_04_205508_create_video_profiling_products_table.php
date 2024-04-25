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
        Schema::create('video_profiling_products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('cover_paper')->nullable();
            $table->string('battery')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('display_area')->nullable();
            $table->string('resolution')->nullable();
            $table->string('memory')->nullable();
            $table->string('description')->nullable();
            $table->string('production_days')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('video_profiling_products');
    }
};
