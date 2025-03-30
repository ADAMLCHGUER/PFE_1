<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestataire_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->foreignId('ville_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('prestations');
            $table->string('coordonnees')->nullable();
            $table->string('adresse');
            $table->string('telephone');
            $table->string('email');
            $table->string('site_web')->nullable();
            $table->json('horaires')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};