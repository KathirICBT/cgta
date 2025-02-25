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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Correct Foreign Key
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('event_categories')->onDelete('cascade');

            $table->enum('event_type', ['public', 'members_only']);
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->string('location');
            $table->string('country');
            $table->boolean('is_free')->default(false);
            $table->integer('max_attendees')->nullable();
            $table->integer('max_tickets_per_person')->default(5);
            $table->string('advertisement_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->date('release_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
