<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventory_items', function (Blueprint $table) {

            // Add inventory_category_id only if missing
            if (!Schema::hasColumn('inventory_items', 'inventory_category_id')) {
                $table->foreignId('inventory_category_id')
                    ->nullable()
                    ->constrained('inventory_categories')
                    ->nullOnDelete()
                    ->after('id');
            }

            // Add staff_id only if missing
            if (!Schema::hasColumn('inventory_items', 'staff_id')) {
                $table->foreignId('staff_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->after('user_id');
            }
        });
    }

    public function down()
    {
        Schema::table('inventory_items', function (Blueprint $table) {

            // Remove inventory_category_id safely
            if (Schema::hasColumn('inventory_items', 'inventory_category_id')) {
                $table->dropForeign(['inventory_category_id']);
                $table->dropColumn('inventory_category_id');
            }

            // Remove staff_id safely
            if (Schema::hasColumn('inventory_items', 'staff_id')) {
                $table->dropForeign(['staff_id']);
                $table->dropColumn('staff_id');
            }
        });
    }
};
