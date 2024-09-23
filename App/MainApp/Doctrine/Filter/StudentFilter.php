<?php

namespace App\MainApp\Doctrine\Filter;

use App\MainApp\Entity\Student;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;


class StudentFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias,): string
    {
        if ($this->hasParameter('userRole') && $this->hasParameter('userGroup')) {

            $userRoles = str_replace("'", "", $this->getParameter('userRole'));
            $userRoles = explode(',', $userRoles);
            $userGroup = str_replace("'", "", $this->getParameter('userGroup'));
            $filterString = "";
            if ($targetEntity->getReflectionClass()->name == Student::class) {
                if (!(in_array('ROLE_ROOT', $userRoles) || in_array('ROLE_ADMIN', $userRoles)) && !($userGroup == "" || $userGroup == null)) {
                    $filterString = $targetTableAlias . '.student_group_id in (' . $userGroup . ')';
                } elseif ($userGroup == "" || $userGroup == null) {
                    $filterString = $targetTableAlias . '.student_group_id in (0)';
                } else {
                    $filterString = '';
                }
            }
            return $filterString;
        }
        return '';
    }

}