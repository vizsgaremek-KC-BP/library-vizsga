<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up()
    {
        Schema::create('book_types', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_number_base');
            $table->string('title');
            $table->string('author');
            $table->integer('price');
            $table->integer('copies');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_types');
    }
};
