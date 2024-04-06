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
        Schema::create('video_profilings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->nullable()->onDelete('cascade')->nullable();
            $table->integer('job_location_id')->constrained('locations')->nullable()->onDelete('cascade');
            $table->string('cover_paper')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('display_area')->nullable();
            $table->string('resolution')->nullable();
            $table->string('battery')->nullable();
            $table->string('memory')->nullable();
            $table->string('production_days')->nullable();
            $table->decimal('total_cost')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('amount_paid')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('order_date')->nullable();
            $table->foreignId('created_by')->constrained('users')->nullable();
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
        Schema::dropIfExists('video_profilings');
    }
};
