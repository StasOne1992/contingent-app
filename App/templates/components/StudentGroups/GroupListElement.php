<?php

namespace App\templates\components\StudentGroups;

use App\mod_education\Repository\StudentGroupsRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class GroupListElement
{
    private StudentGroupsRepository $groupsRepository;

    public function __construct(StudentGroupsRepository $groupsRepository)
    {
        $this->groupsRepository = $groupsRepository;
    }

    public function getStudentGroups(): array
    {
        return $this->groupsRepository->findAll();
    }
}