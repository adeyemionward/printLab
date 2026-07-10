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
        Schema::create('product_pricing_volumes', function (Blueprint $table) {
            $table->id();
            
            // Link to the companies table
            $table->unsignedBigInteger('company_id');
            
            $table->unsignedBigInteger('product_type_id');
            
            // These can be nullable if initialized via the Seeder first
            $table->integer('min_qty')->nullable()->default(100);
            $table->integer('max_qty')->nullable()->default(300);
            $table->decimal('cost', 15, 2)->nullable()->default(0.00);
            
            $table->timestamps();

            // Foreign key relation setup
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');
                  
            $table->foreign('product_type_id')
                  ->references('id')
                  ->on('product_types')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_pricing_volumes');
    }
};