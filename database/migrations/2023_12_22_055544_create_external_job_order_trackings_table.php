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
        Schema::create('external_job_order_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');

            $table->string('pending_status')->nullable();
            $table->string('pending_date')->nullable();

            $table->string('designed_status')->nullable();
            $table->string('designed_date')->nullable();

            $table->string('proof_read_status')->nullable();
            $table->string('proof_read_date')->nullable();

            $table->string('customer_approved_status')->nullable();
            $table->string('customer_approved_date')->nullable();

            $table->string('prepressed_status')->nullable();
            $table->string('prepressed_date')->nullable();

            $table->string('printed_status')->nullable();
            $table->string('printed_date')->nullable();

            $table->string('binded_status')->nullable();
            $table->string('binded_date')->nullable();

            $table->string('completed_status')->nullable();
            $table->string('completed_date')->nullable();

            $table->string('delivered_status')->nullable();
            $table->string('delivered_date')->nullable();

            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_job_order_trackings');
    }
};
