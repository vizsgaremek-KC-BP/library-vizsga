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
        Schema::create('borrowed_books', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_edu_id');
            $table->foreign('user_edu_id')->references('edu_id')->on('users')->onDelete('cascade');
            $table->string('inventory_number'); // Használjuk az inventory_number-t
            $table->foreign('inventory_number')->references('inventory_number')->on('books')->onDelete('cascade');
            $table->enum('status', ['borrowed', 'requested_return', 'returned']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_books');
    }
};
