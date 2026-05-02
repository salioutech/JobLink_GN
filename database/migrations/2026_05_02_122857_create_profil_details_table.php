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
        Schema::create('profil_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('profile_id')->unique()->constrained('profiles')->onDelete('cascade');
        $table->text('competences')->nullable();
        $table->decimal('tarif', 12, 2)->nullable();
        $table->string('devise', 10)->default('GNF');
        $table->boolean('disponibilite')->default(true);
        $table->string('portfolio_url', 255)->nullable();
        $table->string('portfolio_fichier', 255)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_details');
    }
};
