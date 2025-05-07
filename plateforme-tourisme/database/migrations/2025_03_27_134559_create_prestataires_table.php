<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestataires', function (Blueprint $table) {
            $table->id();
            $table->string('nom_entreprise');
            $table->string('telephone');
            $table->text('adresse');
            $table->string('email')->unique();
            $table->string('password'); // Ajout du champ pour le mot de passe
            $table->enum('statut', ['en_revision', 'valide', 'non_valide'])->default('en_revision');
            $table->timestamp('date_validation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestataires');
    }
};