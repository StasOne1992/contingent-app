<?php

namespace App\MainApp\Doctrine\Filter;

use App\mod_education\Entity\StudentGroup;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class studentGroupFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {

        if ($this->hasParameter('userGroup')) {
            return $targetTableAlias . '. id in (' . str_replace("'", "", $this->getParameter('userGroup')) . ')';
        }
        return '';
    }
}