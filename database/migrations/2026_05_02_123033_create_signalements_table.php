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
        Schema::create('signalements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('signaleur_id')->constrained('users')->onDelete('cascade');
        $table->enum('cible_type', ['user','service','offre']);
        $table->unsignedBigInteger('cible_id'); // ID de l'élément signalé
        $table->text('motif');
        $table->enum('statut', ['en_attente','traite','ignore'])->default('en_attente');
        $table->timestamp('created_at')->useCurrent();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
