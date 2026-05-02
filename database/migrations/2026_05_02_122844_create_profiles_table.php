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
        $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
        $table->string('nom', 100);
        $table->string('prenom', 100)->nullable();
        $table->string('photo', 255)->nullable();
        $table->string('localisation', 150)->nullable();
        $table->string('telephone', 20)->nullable();
        $table->text('bio')->nullable();
        $table->tinyInteger('completion_rate')->default(0); // 0 à 100
        // Champs spécifiques Entreprise
        $table->string('secteur_activite')->nullable();
        $table->string('taille_structure')->nullable();
        $table->string('site_web')->nullable();
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
