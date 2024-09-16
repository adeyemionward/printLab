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
        Schema::create('job_order_uniques', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('marketer_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('companies')->nullable();
            $table->string('order_no')->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->unsignedInteger('cart_order_status')->default(false);
            $table->string('status')->nullable();
            $table->date('order_date');
            $table->string('order_type', 50)->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('job_order_uniques');
    }
};
