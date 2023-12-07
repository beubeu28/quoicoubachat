<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use App\Entity\Messagerie;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    private Generator $faker;
    


    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
        

    }

    
    public function load(ObjectManager $manager): void
    {

        // CREATION ADMINISTRATEUR DEFAUT
        $users = [];

        $admin = new User();
        $admin
            ->setNom('Administrateur')
            ->setPrenom('Quoicoubachat')
            ->setEmail('admin@quoicoubachat.fr')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setPassword('$2y$13$LZWQC3ejxi5yclqxNYkHiOkC615/4onX9s1YLQKrIv6NrLbR1.QAe');

            
        $users[] = $admin;
        $manager->persist($admin);

        // CREATION FAUX UTILISATEURS 
        

        



        //CREATION FAUX MESSAGES
        
        
        $manager->flush();


    }
}
