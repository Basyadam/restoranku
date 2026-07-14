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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->integer('stok')->default(0);
            
            // Menggunakan foreignId yang lebih ringkas dan standar Laravel modern
            $table->foreignId('categories_id')->constrained();
            // atau jika manual: $table->unsignedBigInteger('categories_id');
            $table->string('img')->nullable(); // Ditambahkan tanda petik penutup yang hilang (')
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};