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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
          // Relación con usuario
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Foto de perfil
            $table->string('photo')->nullable();

            // Datos comunes
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Campos específicos de Entrenador
            $table->string('specialty')->nullable();
            $table->integer('experience_years')->nullable();
            $table->text('qualifications')->nullable();

            // Campos específicos de Veterinario
            $table->string('clinic_name')->nullable();
            $table->json('schedules')->nullable(); // Guardamos horarios como array JSON

            // Campos específicos de Refugio
            $table->string('responsible')->nullable();

            // Biografía (para Refugio o Veterinario si aplica)
            $table->text('biography')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
