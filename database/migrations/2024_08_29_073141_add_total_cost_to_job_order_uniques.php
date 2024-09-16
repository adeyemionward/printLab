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
        Schema::table('job_order_uniques', function (Blueprint $table) {
            $table->decimal('total_cost', 10, 2)->nullable()->after('order_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_order_uniques', function (Blueprint $table) {
            Schema::dropIfExists('total_cost');
        });
    }
};
