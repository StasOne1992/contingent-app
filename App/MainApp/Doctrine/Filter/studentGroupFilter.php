<?php

namespace App\MainApp\Doctrine\Filter;

use App\MainApp\Entity\StudentGroups;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class studentGroupFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($this->hasParameter('userRole') && $this->hasParameter('userGroup')) {
            $userRole = str_replace("'", "", $this->getParameter('userRole'));
            $userRoles = explode(',', $userRole);
            $userGroup = str_replace("'", "", $this->getParameter('userGroup'));
            $filterString = "";
            if ($targetEntity->getReflectionClass()->name == StudentGroups::class) {
                if (!(in_array('ROLE_ROOT', $userRoles) || in_array('ROLE_ADMIN', $userRoles)) && !($userGroup == "" || $userGroup == null)) {
                    $filterString = $targetTableAlias . '. id in (' . $userGroup . ')';
                } elseif ($userGroup == "" || $userGroup == null) {
                    $filterString = $targetTableAlias . '. id in (0)';

                } else {
                    return '';
                }
            }
            return $filterString;
        }
        return '';
    }
}