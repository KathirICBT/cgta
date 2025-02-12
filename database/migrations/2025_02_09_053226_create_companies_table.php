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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('email')->unique();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->foreignId('region_id')->constrained()->onDelete('cascade');
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('country');
            $table->text('description')->nullable();
            $table->date('joinDate');
            $table->text('services')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
