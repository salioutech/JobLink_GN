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
        Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('categorie_id')->constrained('categories')->onDelete('restrict');
        $table->string('titre', 200);
        $table->text('description');
        $table->decimal('tarif', 12, 2)->nullable();
        $table->string('devise', 10)->default('GNF');
        $table->enum('statut', ['actif','suspendu','supprime'])->default('actif');
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
