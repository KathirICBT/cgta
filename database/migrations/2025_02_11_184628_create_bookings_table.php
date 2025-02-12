<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_type_id')->constrained()->onDelete('cascade');
            $table->date('booking_date');
            $table->integer('tickets_count');
            $table->decimal('subtotal_price', 10, 2); // Price before tax
            $table->decimal('tax_percentage', 5, 2); // Tax rate
            $table->decimal('tax_amount', 10, 2); // Tax amount
            $table->decimal('total_price', 10, 2); // Final price with tax
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('payment_method', ['card', 'paypal', 'bank_transfer', 'cash'])->nullable();
            $table->string('transaction_id')->nullable();
            $table->timestamps();
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
