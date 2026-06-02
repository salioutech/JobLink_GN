<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\User;
use App\Models\Categorie;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les utilisateurs
        $consultant = User::where('email', 'consultant@test.com')->first();
        $artisan    = User::where('email', 'artisan@test.com')->first();
        $tuteur     = User::where('email', 'tuteur@test.com')->first();

        // Récupérer les catégories
        $informatique = Categorie::where('nom', 'Informatique')->first();
        $batiment     = Categorie::where('nom', 'Bâtiment')->first();
        $education    = Categorie::where('nom', 'Éducation')->first();
        $commerce     = Categorie::where('nom', 'Commerce')->first();
        $sante        = Categorie::where('nom', 'Santé')->first();

        // Créer catégories manquantes pour les matières
        $maths    = Categorie::firstOrCreate(['nom' => 'Mathématiques']);
        $physique = Categorie::firstOrCreate(['nom' => 'Physique']);
        $francais = Categorie::firstOrCreate(['nom' => 'Français']);
        $anglais  = Categorie::firstOrCreate(['nom' => 'Anglais']);
        $chimie   = Categorie::firstOrCreate(['nom' => 'Chimie']);

        // ========== 8 SERVICES CONSULTANT ==========
        $servicesConsultant = [
            [
                'titre'       => 'Développement de site web vitrine',
                'description' => 'Je conçois et développe des sites web vitrines professionnels pour votre entreprise. Design moderne, responsive et adapté au contexte guinéen. Livraison en 2 semaines avec formation incluse.',
                'categorie_id'=> $informatique->id,
                'tarif'       => 2500000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Développement application mobile Android',
                'description' => 'Création d\'applications mobiles Android sur mesure pour votre activité. Gestion des commandes, suivi client, catalogue produits. Technologie Flutter, livraison en 3 à 4 semaines.',
                'categorie_id'=> $informatique->id,
                'tarif'       => 4000000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Gestion de la comptabilité mensuelle',
                'description' => 'Je prends en charge la comptabilité mensuelle de votre entreprise : saisie des opérations, rapprochement bancaire, bilan mensuel et déclarations fiscales. Disponible pour PME et TPE à Conakry.',
                'categorie_id'=> $commerce->id,
                'tarif'       => 800000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Création de logo et identité visuelle',
                'description' => 'Je crée votre identité visuelle complète : logo, charte graphique, carte de visite et bannières réseaux sociaux. Livraison des fichiers sources en 5 jours ouvrables.',
                'categorie_id'=> $commerce->id,
                'tarif'       => 1200000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Formation Excel et Word pour professionnels',
                'description' => 'Formation pratique sur Microsoft Excel et Word adaptée aux besoins professionnels guinéens. Tableaux de bord, rapports, facturation. Sessions individuelles ou en groupe de 3 personnes maximum.',
                'categorie_id'=> $informatique->id,
                'tarif'       => 300000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Rédaction de business plan',
                'description' => 'Je rédige votre business plan complet pour la création ou le développement de votre entreprise. Étude de marché, prévisions financières, stratégie commerciale. Idéal pour les demandes de financement.',
                'categorie_id'=> $commerce->id,
                'tarif'       => 1500000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Gestion des réseaux sociaux',
                'description' => 'Je gère vos pages Facebook, Instagram et LinkedIn. Création de contenu, publications régulières, interaction avec votre communauté et rapports mensuels de performance.',
                'categorie_id'=> $commerce->id,
                'tarif'       => 600000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Installation et maintenance de réseaux informatiques',
                'description' => 'Installation de réseaux LAN/WiFi pour bureaux et entreprises. Configuration de routeurs, switches et serveurs. Maintenance préventive et dépannage rapide à Conakry.',
                'categorie_id'=> $informatique->id,
                'tarif'       => 1800000,
                'statut'      => 'actif',
            ],
        ];

        foreach ($servicesConsultant as $data) {
            Service::create(array_merge($data, [
                'user_id' => $consultant->id,
                'devise'  => 'GNF',
            ]));
        }

        // ========== 5 SERVICES ARTISAN ==========
        $servicesArtisan = [
            [
                'titre'       => 'Installation électrique résidentielle',
                'description' => 'Installation complète de tableaux électriques, prises, interrupteurs et éclairage pour maisons et appartements. Travail soigné et conforme aux normes. Devis gratuit sur place à Conakry.',
                'categorie_id'=> $batiment->id,
                'tarif'       => 500000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Plomberie et installation sanitaire',
                'description' => 'Réparation de fuites, installation de robinetterie, douches, WC et chauffe-eau. Intervention rapide dans toutes les communes de Conakry. Disponible les weekends.',
                'categorie_id'=> $batiment->id,
                'tarif'       => 350000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Couture et confection de vêtements sur mesure',
                'description' => 'Confection de boubous, robes, costumes et tenues traditionnelles sur mesure. Tissu bazin, wax et soie. Délai de 5 à 7 jours selon la complexité. Atelier à Ratoma.',
                'categorie_id'=> $commerce->id,
                'tarif'       => 250000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Réparation et entretien de véhicules',
                'description' => 'Vidange, freins, embrayage, révision complète et diagnostic électronique pour toutes marques de véhicules. Garage équipé à Matoto. Pièces d\'origine disponibles.',
                'categorie_id'=> $batiment->id,
                'tarif'       => 400000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Peinture et décoration intérieure',
                'description' => 'Peinture intérieure et extérieure, pose de carrelage, faux plafonds et décoration murale. Travail propre et soigné. Devis gratuit. Intervention dans tout Conakry.',
                'categorie_id'=> $batiment->id,
                'tarif'       => 450000,
                'statut'      => 'actif',
            ],
        ];

        foreach ($servicesArtisan as $data) {
            Service::create(array_merge($data, [
                'user_id' => $artisan->id,
                'devise'  => 'GNF',
            ]));
        }

        // ========== 5 SERVICES TUTEUR ==========
        $servicesTuteur = [
            [
                'titre'       => 'Cours particuliers de Mathématiques — Lycée',
                'description' => 'Soutien scolaire en mathématiques pour élèves de 3ème, 2nde, 1ère et Terminale. Algèbre, géométrie, statistiques et probabilités. Résolution d\'exercices type BAC. Séances à domicile ou en ligne.',
                'categorie_id'=> $maths->id,
                'tarif'       => 150000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Cours de Physique-Chimie — Collège et Lycée',
                'description' => 'Cours particuliers de physique et chimie pour collégiens et lycéens. Mécanique, électricité, thermodynamique et chimie organique. Méthode claire et adaptée au programme guinéen.',
                'categorie_id'=> $physique->id,
                'tarif'       => 150000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Renforcement en Français — Expression écrite et orale',
                'description' => 'Amélioration du niveau en français écrit et oral. Rédaction, dissertation, résumé et commentaire de texte. Préparation aux examens BEPC et BAC. Cours adaptés au niveau de l\'élève.',
                'categorie_id'=> $francais->id,
                'tarif'       => 120000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Cours d\'Anglais — Tous niveaux',
                'description' => 'Cours d\'anglais pour débutants, intermédiaires et avancés. Conversation, grammaire, vocabulaire et préparation aux certifications TOEFL et IELTS. Méthode communicative et interactive.',
                'categorie_id'=> $anglais->id,
                'tarif'       => 200000,
                'statut'      => 'actif',
            ],
            [
                'titre'       => 'Préparation intensive au BAC — Toutes matières',
                'description' => 'Programme de révision intensive pour les candidats au Baccalauréat. Toutes séries confondues. Planning personnalisé, exercices types et simulations d\'examens. Résultats garantis.',
                'categorie_id'=> $education->id,
                'tarif'       => 300000,
                'statut'      => 'actif',
            ],
        ];

        foreach ($servicesTuteur as $data) {
            Service::create(array_merge($data, [
                'user_id' => $tuteur->id,
                'devise'  => 'GNF',
            ]));
        }
    }
}