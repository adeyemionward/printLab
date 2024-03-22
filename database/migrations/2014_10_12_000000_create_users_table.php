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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('nonsh')->nullable();
            $table->string('status')->nullable();
            $table->string('user_type')->nullable()->comment('1=staff, 2=member');
            $table->string('membership_type')->nullable();
            $table->string('membership_no')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->integer('created_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
