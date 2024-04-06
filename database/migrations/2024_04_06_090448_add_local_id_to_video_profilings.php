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
        Schema::table('video_profilings', function (Blueprint $table) {
            $table->string('local_id')->after('cart_order_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_profilings', function (Blueprint $table) {
            Schema::dropIfExists('local_id');
        });
    }
};
