<?php

namespace App\MainApp\Listener;

use App\MainApp\Entity\StudentGroups;
use App\MainApp\Entity\User;
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
            if ($user->getStaff()) {
                $groups = array();
                foreach ($user->getStaff()->getStudentGroups()->getValues() as $group) {
                    $groups[] = (int)$group->getId();
                }
                $filter = $this->em->getFilters()->enable('studentFilter');
                $filter->setParameter('userRole', implode(',', $user->getRoles()));
                $filter->setParameter('userGroup', implode(",",$groups));

                $filter1 = $this->em->getFilters()->enable('studentGroupFilter');
                $filter1->setParameter('userRole', implode(',', $user->getRoles()));
                $filter1->setParameter('userGroup', implode(",",$groups));

                /***
                 * @var StudentGroups $group
                 */
                $studentID=array();
                foreach ($user->getStaff()->getStudentGroups() as $group)
                {
                    foreach ($group->getStudents() as $student)
                    {
                        $studentID[]=$student->getId();
                    }
                }
                $filter2= $this->em->getFilters()->enable('EventsResultFilter');
                $filter2->setParameter('userRole', implode(',', $user->getRoles()));
                $filter2->setParameter('studentId',implode(",",$studentID));
            }
        }
    }
}