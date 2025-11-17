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
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();

            // Reference to the inventory item
            $table->foreignId('item_id')->constrained('inventory_items')->onDelete('cascade');

            // Optional: track the user who performed this action
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Stock before this change
            $table->integer('previous_stock');

            // Quantity added or removed
            $table->integer('qty_change');

            // Current stock after this change
            $table->integer('current_stock');

            // IN = stock added, OUT = stock removed
            $table->enum('type', ['IN', 'OUT']);

            // Optional note or reason (e.g., "Supplier delivery", "Print job #23")
            $table->string('note')->nullable();

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
        Schema::dropIfExists('stock_logs');
    }
};
