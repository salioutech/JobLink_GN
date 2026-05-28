<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('noteable'); // noteable_type + noteable_id
            $table->unsignedTinyInteger('valeur'); // 1 à 5 étoiles
            $table->timestamps();

            // Un utilisateur ne peut noter qu'une seule fois
            $table->unique(['user_id', 'noteable_type', 'noteable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};