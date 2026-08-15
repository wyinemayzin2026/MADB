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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            $table->foreignId('borrower_id')->constrained('borrowers')->onDelete('cascade');

            $table->string('from_email');
            $table->string('to_email');
            $table->string('subject');
            $table->text('body');

            // Store array of image paths (JSON)
            $table->json('images')->nullable();

            // Optional status tracking
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
