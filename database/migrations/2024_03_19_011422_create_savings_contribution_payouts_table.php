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
        Schema::create('savings_contribution_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('mode')->nullable();
            $table->string('date');
            $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('savings_contribution_payouts');
    }
};
