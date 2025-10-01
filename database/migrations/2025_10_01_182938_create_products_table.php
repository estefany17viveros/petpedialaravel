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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Nombre del producto
        $table->decimal('price', 10, 2);     // Precio
        $table->text('description')->nullable(); // Descripción
        $table->string('category');          // Categoría (alimentos, medicamentos, accesorios)
        $table->string('image')->nullable(); // Imagen (ruta guardada)
       $table->foreignId('profile_id')->nullable()->constrained('profiles');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
