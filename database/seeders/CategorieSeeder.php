<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nom'         => 'Informatique',
                'description' => 'Développement web, design, réseaux, maintenance informatique',
                'icone'       => 'fa-laptop-code',
            ],
            [
                'nom'         => 'Bâtiment',
                'description' => 'Maçonnerie, électricité, plomberie, carrelage, peinture',
                'icone'       => 'fa-hard-hat',
            ],
            [
                'nom'         => 'Éducation',
                'description' => 'Cours particuliers, formation, langues, soutien scolaire',
                'icone'       => 'fa-graduation-cap',
            ],
            [
                'nom'         => 'Commerce',
                'description' => 'Vente, gestion de stock, caisse, commercial terrain',
                'icone'       => 'fa-store',
            ],
            [
                'nom'         => 'Santé',
                'description' => 'Aide-soignant, secrétariat médical, soins à domicile',
                'icone'       => 'fa-heartbeat',
            ],
            [
                'nom'         => 'Transport',
                'description' => 'Chauffeur, coursier, livraison, déménagement',
                'icone'       => 'fa-car',
            ],
            [
                'nom'         => 'Autre',
                'description' => 'Tout métier ou service non listé dans les catégories ci-dessus',
                'icone'       => 'fa-briefcase',
            ],
        ];

        foreach ($categories as $categorie) {
            Categorie::firstOrCreate(
                ['nom' => $categorie['nom']],
                $categorie
            );
        }
    }
}