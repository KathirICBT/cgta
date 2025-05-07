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
        Schema::create('member_privacies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id'); // FK to members
            $table->string('field_name'); // e.g., photo, email, phone, dob
            $table->boolean('global_private')->default(false); // true if all fields are private
            $table->unsignedBigInteger('privacy_level_id'); // FK to privacy_levels
            $table->timestamps();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('privacy_level_id')->references('id')->on('privacy_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_privacies');
    }
};
