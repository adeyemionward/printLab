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
        Schema::table('product_costs', function (Blueprint $table) {
            $table->string('thickness')->nullable()->after('quantity'); 
            $table->string('ink')->nullable()->after('quantity');
            $table->string('paper_type')->nullable()->after('quantity');
            $table->string('memory')->nullable()->after('quantity');
            $table->string('cover_paper')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_costs', function (Blueprint $table) {
            Schema::dropIfExists('thickness');
            Schema::dropIfExists('ink');
            Schema::dropIfExists('paper_type');
            Schema::dropIfExists('cover_paper');
            Schema::dropIfExists('memory');
        });
    }
};
