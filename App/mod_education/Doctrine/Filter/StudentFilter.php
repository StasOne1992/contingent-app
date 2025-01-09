<?php

namespace App\mod_education\Doctrine\Filter;

use App\mod_education\Entity\Student;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;


class StudentFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias,): string
    {
      if ($this->hasParameter('userRole') && $this->hasParameter('userGroup')) {
            $userRoles = json_decode(str_replace("'", "",$this->getParameter('userRole')));
            $userGroup = json_decode(str_replace("'", "",$this->getParameter('userGroup')));
            $filterString = $targetTableAlias;
            if ($targetEntity->getReflectionClass()->name == Student::class) {


                if ((in_array('ROLE_ROOT', $userRoles) || in_array('ROLE_ADMIN', $userRoles)))
                {
                    dump("ForRootFilterEnable");

                }
                else if ((in_array('ROLE_USER',$userRoles)) && !($userGroup == "" || $userGroup == null))
                {
                    dump("ForUserFilterEnableWithoutNullUserGroupList");

                }
                if (!(in_array('ROLE_ROOT', $userRoles) || in_array('ROLE_ADMIN', $userRoles))
                   ) {
                dump("then not ROOT");
                    $filterString = $filterString . '.student_group_id in (' . $userGroup . ')';
                } elseif ($userGroup == "" || $userGroup == null) {
                    dump("else not ROOT");
                    $filterString = $filterString . '.student_group_id in (0)';
                } else {
                    dump("then ROOT");
                }

                dd($filterString);
                return $filterString;
            }

            dump($filterString);
            return $filterString;
        }

        return '';

    }

}