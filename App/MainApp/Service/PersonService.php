<?php

namespace App\MainApp\Service;
use App\MainApp\Entity\Person;
use App\MainApp\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonService extends AbstractController
{
    private PersonRepository $personRepository;
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em,
    )
    {
        $this->em = $em;

    }

    public function createPerson(Person $person)
    {
        $this->personRepository;

    }
}