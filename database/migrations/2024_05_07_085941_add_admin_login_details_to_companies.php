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
            $table->string('admin_username')->after('email')->nullable();
            $table->string('admin_password')->after('email')->nullable();
        });
       // 03-21  create sub__ down //admin login --- 05-02// create sub
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            Schema::dropIfExists('admin_username');
            Schema::dropIfExists('admin_password');
        });
    }
};
