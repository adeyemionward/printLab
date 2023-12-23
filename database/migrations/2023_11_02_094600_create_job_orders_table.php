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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('job_order_name')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('size')->nullable();
            $table->string('ink')->nullable();
            $table->string('thickness')->nullable();
            $table->string('paper_type')->nullable();
            $table->string('bleed')->nullable();
            $table->string('page_count')->nullable();
            $table->string('folding')->nullable();
            $table->string('shrink_wrap')->nullable();
            $table->string('production_days')->nullable();
            $table->string('back_sided_print')->nullable();
            $table->string('proof_needed')->nullable();
            $table->string('hole_drilling')->nullable();
            $table->string('perforating')->nullable();
            $table->string('edge_to_glue')->nullable();
            $table->string('binding')->nullable();
            $table->string('binding_edge')->nullable();
            $table->string('cut_to_size')->nullable();
            $table->string('books_with_covers')->nullable();
            $table->string('numbering_needed')->nullable();
            $table->string('start_number')->nullable();
            $table->string('total_cost')->nullable();
            $table->enum('status', ['Pending', 'Designed','Proof Read','Customer Approved','Prepressed','Printed','Binded','Completed','Delivered'])->default('pending');
            $table->string('order_date')->nullable();
            $table->string('order_type')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('job_orders');
    }
};
