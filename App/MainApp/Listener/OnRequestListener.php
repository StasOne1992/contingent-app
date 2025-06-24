<?php

namespace App\MainApp\Listener;

use App\MainApp\Entity\User;
use App\mod_education\Entity\StudentGroup;
use App\mod_education\Repository\StudentGroupsRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class OnRequestListener
{
    /***
     * @var EntityManager em
     */
    protected $em;
    protected $tokenStorage;

    public function __construct($em, $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->tokenStorage->getToken()) {
            /***
             * @var User $user
             */
            $user = $this->tokenStorage->getToken()->getUser();
            $roles = $user->getRoles();
            $groups = array();
            if (in_array('ROLE_ROOT', $roles) || in_array('ROLE_ADMIN', $roles)) {
                dump('RootGroupList');
                foreach ($this->em->getRepository(StudentGroup::class)->findAll() as $group) {
                    $groups[] = $group->getId();
                }
            } else if (in_array('ROLE_USER', $roles)) {
                if ($user->getStaff()) {
                    foreach ($user->getStaff()->getStudentGroups()->getValues() as $group) {
                        $groups[] = (int)$group->getId();
                    }
                }
                //$groups[] = 5;

                $studentFilter = $this->em->getFilters()->enable('studentFilter');
                $studentFilter->setParameter('userRole', json_encode($roles), 'json');
                $studentFilter->setParameter('userGroup', json_encode($groups), 'json');


                $studentGroupFilter = $this->em->getFilters()->enable('studentGroupFilter');
                $studentGroupFilter->setParameter('userRole', implode(',', $user->getRoles()));
                $studentGroupFilter->setParameter('userGroup', implode(",", $groups));


                /***
                 * @var StudentGroup $group
                 */
                $studentID = [];
                if ($groups = $user->getStaff()->getStudentGroups()) {
                    foreach ($groups as $group) {
                        foreach ($group->getStudents() as $student) {
                            $studentID[] = $student->getId();
                        }
                    }
                    if (count($studentID) > 0) {
                        $EventsResultFilter = $this->em->getFilters()->enable('EventsResultFilter');
                        $EventsResultFilter->setParameter('userRole', implode(',', $user->getRoles()));
                        $EventsResultFilter->setParameter('studentId', implode(",", $studentID));
                    }
                }
            }
        }
    }
}