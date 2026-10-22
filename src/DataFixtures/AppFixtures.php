<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etat;
use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

        foreach ($categories as $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);

            $manager->persist($categorie);
        }

        $etats = [
            'Nouveau',
            'Ouvert',
            'Résolu',
            'Fermé'
        ];

        foreach ($etats as $nom) {
            $etat = new Etat();
            $etat->setNom($nom);

            $manager->persist($etat);
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

        $user = new User();

        $user->setNom('Dupont');
        $user->setPrenom('Jean');
        $user->setEmail('jean.dupont@example.com');
        $user->setRoles(['ROLE_USER']);

        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                'PersonnelTest2026!'
            )
        );

        $manager->persist($user);

        $user = new User();

        $user->setNom('Martin');
        $user->setPrenom('Sophie');
        $user->setEmail('sophie.martin@example.com');
        $user->setRoles(['ROLE_USER']);

        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                'PersonnelTest2026!'
            )
        );

        $manager->persist($user);

        $manager->flush();
    }
}
