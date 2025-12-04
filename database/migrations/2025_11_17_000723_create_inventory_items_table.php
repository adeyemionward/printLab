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
            Schema::create('inventory_items', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                 // Item Name
                $table->string('item_name');

                // Unit of measurement (pcs, ream, bottle, etc.)
                $table->string('unit')->nullable();

                // Minimum stock level
                $table->integer('min_stock')->default(0);

                // Description (optional)
                $table->text('description')->nullable();

                // Current stock (optional if using stock_logs)
                $table->integer('current_stock')->default(0);

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
        Schema::dropIfExists('inventory_items');
    }
};
