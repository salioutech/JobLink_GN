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

        // ========== FREELANCE ==========
        $freelance = User::firstOrCreate(
            ['email' => 'freelance@test.com'],
            [
                'password' => Hash::make('Test@1234'),
                'role'     => 'freelance',
                'statut'   => 'actif',
            ]
        );
        $profileFreelance = Profile::firstOrCreate(
            ['user_id' => $freelance->id],
            [
                'nom'             => 'Diallo',
                'prenom'          => 'Mamadou',
                'localisation'    => 'Ratoma',
                'telephone'       => '622000001',
                'bio'             => 'Développeur web spécialisé Laravel et Vue.js',
                'completion_rate' => 70,
            ]
        );
        ProfilDetail::firstOrCreate(
            ['profile_id' => $profileFreelance->id],
            [
                'competences'   => 'Laravel, PHP, MySQL, Vue.js, Bootstrap',
                'tarif'         => 500000,
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
                'secteur_activite' => 'Informatique & Technologie',
                'taille_structure' => 'PME (10–49 employés)',
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