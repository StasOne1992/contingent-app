<?php

namespace App\MainApp\Doctrine\Filter;

use App\MainApp\Entity\EventsResult;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class EventsResultFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        $filterString = "";
        if ($this->hasParameter('userRole') && $this->hasParameter('studentId')) {
            $userRoles = str_replace("'", "", $this->getParameter('userRole'));
            $userRoles = explode(',', $userRoles);
            $studentId = str_replace("'", "", $this->getParameter('studentId'));
            if ($targetEntity->getReflectionClass()->name == EventsResult::class) {
                $filterString = $targetTableAlias . '.student_id in ('.$studentId.')';
            }
        }

        return $filterString;
    }
}