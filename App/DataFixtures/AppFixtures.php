<?php

namespace App\DataFixtures;

use App\MainApp\Entity\Staff;
use App\MainApp\Entity\User;
use App\mod_mosregvis\Entity\MosregVISCollege;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher, UserPasswordHasherInterface $userPasswordHasher
    )
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $college = new MosregVISCollege();
        $college->setname('demo college');
        $college->setEmail('college@example.com');
        $college->setShortName('college');

        $staff_admin=new Staff();
        $staff_admin->setFirstName('Administrator');
        $staff_admin->setLastName('LastName');
        $staff_admin->setMiddleName('');
        $staff_admin->setEmail('administrator@example.com');
        $staff_admin->addCollege($college);

        $user = new User();
        $user->setCollege($college);
        $user->setEmail($staff_admin->getEmail());
        $plaintextPassword = 'changeme';
        $hashedPassword = $this->userPasswordHasher->hashPassword($user,$plaintextPassword);
        $user->setPassword($hashedPassword);
        $user->setIsStudent(false);
        $user->setRoles(array(['ROLE_ROOT']));


        $manager->flush();
    }
}