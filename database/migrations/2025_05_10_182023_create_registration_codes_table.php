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
        Schema::create('registration_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('member_id'); // member id
            $table->string('registration_code')->unique();
            $table->integer('max_usage')->default(1);
            $table->integer('used_count')->default(0);
            $table->enum('status', ['ACTIVE', 'EXPIRED'])->default('ACTIVE');
            $table->timestamps();
            $table->timestamp('expires_at')->nullable();

            // Foreign keys
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_codes');
    }
};
