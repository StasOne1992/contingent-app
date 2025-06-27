<?php

namespace App\MainApp\Doctrine\Filter;

use App\mod_education\Entity\Student;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;


class StudentFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias,): string
    {

        if ($this->hasParameter('userGroup')) {
            $filterString = $targetTableAlias . '.student_group_id in (' . $userGroup . ')';
        }
        return $filterString;
    }

}