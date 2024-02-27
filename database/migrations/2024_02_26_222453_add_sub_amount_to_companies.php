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
        Schema::table('companies', function (Blueprint $table) {
            $table->decimal('sub_amount', 8, 2)->after('address')->nullable();
            $table->string('sub_start_date')->after('sub_amount')->nullable();
            $table->string('sub_end_date')->after('sub_start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            Schema::dropIfExists('sub_amount');
            Schema::dropIfExists('sub_start_date');
            Schema::dropIfExists('sub_end_date');
        });
    }
};
