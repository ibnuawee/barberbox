<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('barber_id');
            $table->unsignedBigInteger('service_id');
            $table->string('haircut_name');
            $table->timestamp('booking_date');
            $table->enum('gender', ['pria', 'wanita']);
            $table->string('status')->default('pending');
            $table->string('invoice_number')->unique();
            $table->decimal('total_price', 8, 2);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('barber_id')->references('id')->on('barbers')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
