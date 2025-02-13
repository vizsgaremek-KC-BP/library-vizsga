<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('book_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books');
            $table->string('class');
            $table->enum('status', ['assigned', 'returned', 'pending'])->default('assigned');
            $table->timestamps();
        });
    }
};
