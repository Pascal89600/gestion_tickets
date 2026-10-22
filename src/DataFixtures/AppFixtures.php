<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etat;
use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Ticket;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}



    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Incident',
            'Panne',
            'Evolution',
            'Anomalie',
            'Information'
        ];
        $categoriesObjets = [];
        foreach ($categories as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);

            $manager->persist($categorie);

            $categoriesObjets[$nom] = $categorie;
        }

        $etats = [
            'Nouveau',
            'Ouvert',
            'Résolu',
            'Fermé'
        ];
        $etatsObjets = [];
        foreach ($etats as $nom) {
            $etat = new Etat();
            $etat->setNom($nom);

            $manager->persist($etat);

            $etatsObjets[$nom] = $etat;
        }
        $admin = new User();

        $admin->setNom('Admin');
        $admin->setPrenom('Principal');
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);

        $admin->setPassword(
            $this->passwordHasher->hashPassword(
                $admin,
                'AdminTest2026!'
            )
        );

        $manager->persist($admin);

        $jean = new User();

       
        $jean->setNom('Dupont');
        $jean->setPrenom('Jean');
        $jean->setEmail('jean.dupont@example.com');
        $jean->setRoles(['ROLE_USER']);

        $jean->setPassword(
            $this->passwordHasher->hashPassword(
                $jean,
                'PersonnelTest2026!'
            )
        );

        $manager->persist($jean);

     

        $sophie = new User();

        $sophie->setNom('Martin');
        $sophie->setPrenom('Sophie');
        $sophie->setEmail('sophie.martin@example.com');
        $sophie->setRoles(['ROLE_USER']);

        $sophie->setPassword(
            $this->passwordHasher->hashPassword(
                $sophie,
                'PersonnelTest2026!'
            )
        );

        $manager->persist($sophie);

        $ticket = new Ticket();

        $ticket->setEmail('client1@example.com');
        $ticket->setDescription(
            'Je rencontre un problème de connexion à mon espace client.'
        );

        $ticket->setCategorie($categoriesObjets['Incident']);
        $ticket->setEtat($etatsObjets['Nouveau']);

        $manager->persist($ticket);

        $ticket = new Ticket();

        $ticket->setEmail('client2@example.com');
        $ticket->setDescription(
            'Le site Internet est inaccessible depuis ce matin.'
        );

        $ticket->setCategorie($categoriesObjets['Panne']);
        $ticket->setEtat($etatsObjets['Ouvert']);
        $ticket->setResponsable($jean);

        $manager->persist($ticket);

        $ticket = new Ticket();

        $ticket->setEmail('client3@example.com');
        $ticket->setDescription(
            'Je souhaite ajouter une nouvelle rubrique à mon site Internet.'
        );

        $ticket->setCategorie($categoriesObjets['Evolution']);
        $ticket->setEtat($etatsObjets['Résolu']);
        $ticket->setResponsable($sophie);

        $manager->persist($ticket);



        $manager->flush();
    }
}
