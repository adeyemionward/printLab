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
        Schema::table('job_orders', function (Blueprint $table) {
            $table->string('cover_paper')->nullable()->after('start_number');
            $table->string('screen_size')->nullable()->after('cover_paper');
            $table->string('display_area')->nullable()->after('screen_size');
            $table->string('resolution')->nullable()->after('display_area');
            $table->string('battery')->nullable()->after('resolution');
            $table->string('memory')->nullable()->after('battery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_orders', function (Blueprint $table) {
            Schema::dropIfExists('cover_paper');
            Schema::dropIfExists('screen_size');
            Schema::dropIfExists('display_area');
            Schema::dropIfExists('resolution');
            Schema::dropIfExists('battery');
            Schema::dropIfExists('memory');
        });
    }
};
