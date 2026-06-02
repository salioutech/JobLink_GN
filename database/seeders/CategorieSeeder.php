<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        // ── Catégories générales ─────────────────────────
        $generales = [
            ['nom' => 'Informatique', 'description' => 'Développement web, design, réseaux, maintenance', 'icone' => 'fa-laptop-code'],
            ['nom' => 'Bâtiment',     'description' => 'Maçonnerie, électricité, plomberie, peinture',    'icone' => 'fa-hard-hat'],
            ['nom' => 'Éducation',    'description' => 'Cours particuliers, formation, soutien scolaire', 'icone' => 'fa-graduation-cap'],
            ['nom' => 'Commerce',     'description' => 'Vente, gestion de stock, commercial terrain',      'icone' => 'fa-store'],
            ['nom' => 'Santé',        'description' => 'Aide-soignant, soins à domicile',                 'icone' => 'fa-heartbeat'],
            ['nom' => 'Transport',    'description' => 'Chauffeur, coursier, livraison',                  'icone' => 'fa-car'],
            ['nom' => 'Autre',        'description' => 'Tout service non listé ci-dessus',                'icone' => 'fa-briefcase'],
        ];

        foreach ($generales as $cat) {
            Categorie::firstOrCreate(
                ['nom' => $cat['nom']],
                array_merge($cat, ['pour_tuteur' => false])
            );
        }

        // ── Catégories tuteur (matières) ─────────────────
        $matieres = [
            'Mathématiques', 'Physique-Chimie', 'Français',
            'Anglais', 'SVT', 'Histoire-Géographie',
            'Philosophie', 'Informatique scolaire', 'Arabe',
        ];

        foreach ($matieres as $matiere) {
            Categorie::firstOrCreate(
                ['nom' => $matiere],
                ['nom' => $matiere, 'description' => 'Matière scolaire', 'icone' => 'fa-book', 'pour_tuteur' => true]
            );
        }
    }
}