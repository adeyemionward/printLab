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
        Schema::table('stock_logs', function (Blueprint $table) {
            // Add inventory_category_id only if missing
            if (!Schema::hasColumn('stock_logs', 'receiver_id')) {
                $table->foreignId('receiver_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->after('user_id');
            }

            // Add staff_id only if missing
            if (!Schema::hasColumn('stock_logs', 'supplier_id')) {
                $table->foreignId('supplier_id')
                    ->nullable()
                    ->constrained('suppliers')
                    ->nullOnDelete()
                    ->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_logs', function (Blueprint $table) {
            //
        });
    }
};
