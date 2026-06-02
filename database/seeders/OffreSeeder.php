<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offre;
use App\Models\User;
use App\Models\Categorie;

class OffreSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les utilisateurs
        $entreprise  = User::where('email', 'entreprise@test.com')->first();
        $particulier = User::where('email', 'particulier@test.com')->first();

        // Récupérer les catégories
        $informatique = Categorie::where('nom', 'Informatique')->first();
        $batiment     = Categorie::where('nom', 'Bâtiment')->first();
        $education    = Categorie::where('nom', 'Éducation')->first();
        $commerce     = Categorie::where('nom', 'Commerce')->first();
        $sante        = Categorie::where('nom', 'Santé')->first();

        // ========== 5 OFFRES ENTREPRISE ==========
        $offresEntreprise = [
            [
                'titre'               => 'Développeur Web Full Stack — Laravel',
                'type'                => 'emploi',
                'description'         => 'TechGuinée SARL recrute un développeur web Full Stack maîtrisant Laravel et Vue.js. Vous serez en charge du développement et de la maintenance de nos applications web. Expérience minimum 2 ans requise. Poste basé à Kaloum, Conakry.',
                'competences_requises'=> 'Laravel, PHP, Vue.js, MySQL, Bootstrap',
                'budget'              => 3500000,
                'duree'               => 'CDI',
                'categorie_id'        => $informatique->id,
                'statut'              => 'active',
            ],
            [
                'titre'               => 'Responsable Commercial et Marketing',
                'type'                => 'emploi',
                'description'         => 'Nous recherchons un responsable commercial dynamique pour développer notre portefeuille clients en Guinée. Vous aurez en charge la prospection, la négociation et le suivi commercial. Véhicule de fonction fourni.',
                'competences_requises'=> 'Vente, Négociation, Marketing digital, Communication',
                'budget'              => 2500000,
                'duree'               => 'CDI',
                'categorie_id'        => $commerce->id,
                'statut'              => 'active',
            ],
            [
                'titre'               => 'Mission de refonte du site web institutionnel',
                'type'                => 'mission',
                'description'         => 'TechGuinée SARL lance un appel à candidatures pour la refonte complète de son site web institutionnel. Le projet inclut le design, le développement et l\'intégration d\'un système de gestion de contenu. Délai de livraison : 3 semaines.',
                'competences_requises'=> 'WordPress, Design UI/UX, HTML/CSS, SEO',
                'budget'              => 2000000,
                'duree'               => '3 semaines',
                'categorie_id'        => $informatique->id,
                'statut'              => 'active',
            ],
            [
                'titre'               => 'Comptable junior pour PME',
                'type'                => 'emploi',
                'description'         => 'Nous recrutons un comptable junior pour gérer la comptabilité quotidienne de notre entreprise. Saisie des écritures, rapprochements bancaires, déclarations fiscales mensuelles. Formation assurée en interne.',
                'competences_requises'=> 'Comptabilité, SYSCOHADA, Excel, Rigueur',
                'budget'              => 1800000,
                'duree'               => 'CDD 6 mois renouvelable',
                'categorie_id'        => $commerce->id,
                'statut'              => 'active',
            ],
            [
                'titre'               => 'Formation en bureautique pour nos équipes',
                'type'                => 'demande_service',
                'description'         => 'TechGuinée SARL recherche un formateur en bureautique pour former 10 employés sur Microsoft Office (Word, Excel, PowerPoint). Formation de 2 jours, dans nos locaux à Kaloum. Matériel informatique disponible sur place.',
                'competences_requises'=> 'Microsoft Office, Pédagogie, Formation',
                'budget'              => 1000000,
                'duree'               => '2 jours',
                'categorie_id'        => $education->id,
                'statut'              => 'active',
            ],
        ];

        foreach ($offresEntreprise as $data) {
            Offre::create(array_merge($data, [
                'user_id' => $entreprise->id,
            ]));
        }

        // ========== 5 OFFRES PARTICULIER ==========
        $offresParticulier = [
            [
                'titre'               => 'Recherche électricien pour installation maison',
                'type'                => 'demande_service',
                'description'         => 'Je recherche un électricien qualifié pour l\'installation complète du système électrique de ma maison en construction à Ratoma. Travaux : tableau électrique, prises, éclairage intérieur et extérieur. Devis demandé avant intervention.',
                'competences_requises'=> 'Électricité, Installation tableau, Norme électrique',
                'budget'              => 1500000,
                'duree'               => '1 semaine',
                'categorie_id'        => $batiment->id,
                'statut'              => 'active',
            ],
            [
                'titre'               => 'Tuteur de mathématiques pour ma fille en Terminale',
                'type'                => 'demande_service',
                'description'         => 'Je cherche un tuteur sérieux et expérimenté pour donner des cours particuliers de mathématiques à ma fille en classe de Terminale S. Séances de 2h, 3 fois par semaine à notre domicile à Dixinn. Préparation au BAC.',
                'competences_requises'=> 'Mathématiques, Pédagogie, Patience, BAC',
                'budget'              => 400000,
                'duree'               => '3 mois',
                'categorie_id'        => $education->id,
                'statut'              => 'active',
            ],
            [
                'titre'               => 'Couturière pour robe de cérémonie',
                'type'                => 'demande_service',
                'description'         => 'Je recherche une couturière talentueuse pour la confection d\'une robe de cérémonie en tissu bazin. Modèle moderne avec broderies traditionnelles guinéennes. Tissu fourni par mes soins. Délai souhaité : 10 jours.',
                'competences_requises'=> 'Couture, Broderie, Bazin, Créativité',
                'budget'              => 300000,
                'duree'               => '10 jours',
                'categorie_id'        => $commerce->id,
                'statut'              => 'active',
            ],
            [
                'titre'               => 'Plombier pour réparation fuite d\'eau urgente',
                'type'                => 'demande_service',
                'description'         => 'Fuite d\'eau importante dans ma salle de bain à Matoto. Recherche plombier disponible rapidement pour intervention d\'urgence. Tuyau endommagé sous l\'évier. Disponible dès aujourd\'hui ou demain matin.',
                'competences_requises'=> 'Plomberie, Réparation, Disponibilité immédiate',
                'budget'              => 200000,
                'duree'               => '1 jour',
                'categorie_id'        => $batiment->id,
                'statut'              => 'active',
            ],
            [
                'titre'               => 'Développeur pour application de gestion de stock',
                'type'                => 'mission',
                'description'         => 'Je suis commerçant à Madina et je cherche un développeur pour créer une application simple de gestion de stock pour ma boutique. Fonctionnalités souhaitées : entrées/sorties de stock, alertes de rupture et rapports mensuels.',
                'competences_requises'=> 'Développement, Base de données, Interface simple',
                'budget'              => 1200000,
                'duree'               => '2 semaines',
                'categorie_id'        => $informatique->id,
                'statut'              => 'active',
            ],
        ];

        foreach ($offresParticulier as $data) {
            Offre::create(array_merge($data, [
                'user_id' => $particulier->id,
            ]));
        }
    }
}