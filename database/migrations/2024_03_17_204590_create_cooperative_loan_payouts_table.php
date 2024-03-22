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
        Schema::create('cooperative_loan_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('amount_payout', 10, 2);
            $table->decimal('amount_repayed', 10, 2);
            $table->string('date');
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
        Schema::dropIfExists('cooperative_loan_payouts');
    }
};
