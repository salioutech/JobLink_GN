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
        Schema::create('demande_contacts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('demandeur_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('offreur_id')->constrained('users')->onDelete('cascade');
        $table->text('message')->nullable();
        $table->enum('statut', ['en_attente','acceptee','refusee'])->default('en_attente');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_contacts');
    }
};
