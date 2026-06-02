<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\ProfilDetail;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ========== ADMIN ==========
        $admin = User::firstOrCreate(
            ['email' => 'admin@joblinkgn.com'],
            [
                'password' => Hash::make('Admin@1234'),
                'role'     => 'admin',
                'statut'   => 'actif',
            ]
        );
        Profile::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'nom'             => 'Administrateur',
                'prenom'          => 'JobLink',
                'localisation'    => 'Kaloum',
                'completion_rate' => 100,
            ]
        );

        // ========== CONSULTANT ==========
        $consultant = User::firstOrCreate(
            ['email' => 'consultant@test.com'],
            [
                'password' => Hash::make('Test@1234'),
                'role'     => 'consultant',
                'statut'   => 'actif',
            ]
        );
        $profileConsultant = Profile::firstOrCreate(
            ['user_id' => $consultant->id],
            [
                'nom'             => 'Diallo',
                'prenom'          => 'Mamadou',
                'localisation'    => 'Ratoma',
                'telephone'       => '622000001',
                'bio'             => 'Consultant web spécialisé Laravel et Vue.js',
                'completion_rate' => 70,
            ]
        );
        ProfilDetail::firstOrCreate(
            ['profile_id' => $profileConsultant->id],
            [
                'competences'   => 'Laravel, PHP, MySQL, Vue.js, Bootstrap',
                'tarif'         => 500000,
                'devise'        => 'GNF',
                'disponibilite' => true,
                'portfolio_url' => null,
            ]
        );

        // ========== ARTISAN ==========
        $artisan = User::firstOrCreate(
            ['email' => 'artisan@test.com'],
            [
                'password' => Hash::make('Test@1234'),
                'role'     => 'artisan',
                'statut'   => 'actif',
            ]
        );
        $profileArtisan = Profile::firstOrCreate(
            ['user_id' => $artisan->id],
            [
                'nom'             => 'Camara',
                'prenom'          => 'Ibrahima',
                'localisation'    => 'Matoto',
                'telephone'       => '622000003',
                'bio'             => 'Électricien qualifié avec 5 ans d\'expérience à Conakry',
                'completion_rate' => 75,
            ]
        );
        ProfilDetail::firstOrCreate(
            ['profile_id' => $profileArtisan->id],
            [
                'competences'   => 'Électricité, Installation, Dépannage, Câblage',
                'tarif'         => 300000,
                'devise'        => 'GNF',
                'disponibilite' => true,
                'portfolio_url' => null,
            ]
        );

        // ========== TUTEUR ==========
        $tuteur = User::firstOrCreate(
            ['email' => 'tuteur@test.com'],
            [
                'password' => Hash::make('Test@1234'),
                'role'     => 'tuteur',
                'statut'   => 'actif',
            ]
        );
        $profileTuteur = Profile::firstOrCreate(
            ['user_id' => $tuteur->id],
            [
                'nom'             => 'Barry',
                'prenom'          => 'Fatoumata',
                'localisation'    => 'Dixinn',
                'telephone'       => '622000004',
                'bio'             => 'Enseignante en mathématiques et physique, niveau lycée et université',
                'completion_rate' => 80,
            ]
        );
        ProfilDetail::firstOrCreate(
            ['profile_id' => $profileTuteur->id],
            [
                'competences'   => 'Mathématiques, Physique, Chimie, Soutien scolaire',
                'tarif'         => 150000,
                'devise'        => 'GNF',
                'disponibilite' => true,
                'portfolio_url' => null,
            ]
        );

        // ========== ENTREPRISE ==========
        $entreprise = User::firstOrCreate(
            ['email' => 'entreprise@test.com'],
            [
                'password' => Hash::make('Test@1234'),
                'role'     => 'entreprise',
                'statut'   => 'actif',
            ]
        );
        Profile::firstOrCreate(
            ['user_id' => $entreprise->id],
            [
                'nom'              => 'TechGuinée SARL',
                'prenom'           => null,
                'localisation'     => 'Kaloum',
                'telephone'        => '622000002',
                'bio'              => 'Entreprise spécialisée en solutions numériques pour la Guinée',
                'secteur_activite' => 'Informatique',
                'taille_structure' => 'PME',
                'completion_rate'  => 80,
            ]
        );

        // ========== PARTICULIER ==========
        $particulier = User::firstOrCreate(
            ['email' => 'particulier@test.com'],
            [
                'password' => Hash::make('Test@1234'),
                'role'     => 'particulier',
                'statut'   => 'actif',
            ]
        );
        Profile::firstOrCreate(
            ['user_id' => $particulier->id],
            [
                'nom'             => 'Kouyaté',
                'prenom'          => 'Aminata',
                'localisation'    => 'Lambanyi',
                'telephone'       => '622000005',
                'bio'             => 'Particulière à la recherche de prestataires fiables à Conakry',
                'completion_rate' => 60,
            ]
        );
    }
}