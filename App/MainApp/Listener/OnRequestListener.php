<?php

namespace App\MainApp\Listener;

use App\MainApp\Entity\Staff;
use App\MainApp\Entity\User;
use App\mod_education\Entity\GroupMembership;
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
             * @var      $studentGroup StudentGroup
             * @var      $user         User
             */

            $user = $this->tokenStorage->getToken()->getUser();
            $studentGroupList = $user->getStaff()->getStudentGroups();
            $studentGroupIdList = $user->getStaff()->getStudentGroupsId();

            $userRoles = $user->getRoles();

            if (!in_array('ROLE_ROOT', $userRoles) && in_array('ROLE_USER', $userRoles)) {
                if (in_array('ROLE_CL', $userRoles)) {
                    $studentGroupFilter = $this->em->getFilters()->enable('studentGroupFilter');
                    $studentGroupFilter->setParameter('userGroup', implode(',', $studentGroupIdList));

                    $studentFilter = $this->em->getFilters()->enable('studentFilter');
                    $studentFilter->setParameter('userRole', json_encode($userRoles), 'json');
                    $studentFilter->setParameter('userGroup', json_encode($studentGroupIdList), 'json');
                    dump('role_cl');
                }
                if (in_array('ROLE_ADMIN', $userRoles)) {
                    dump('role_admin');
                }
            }
            /*    $studentFilter = $this->em->getFilters()->enable('studentFilter');
                $studentFilter->setParameter('userRole', json_encode($userRoles), 'json');
                $studentFilter->setParameter('userGroup', json_encode($studentGroupIdList), 'json');*/

            /*  $studentGroupFilter = $this->em->getFilters()->enable('studentGroupFilter');
              $studentGroupFilter->setParameter('userRole', implode(',', $user->getRoles()));
              $studentGroupFilter->setParameter('userGroup', implode(",", $groups));*/


                /***
                 * @var StudentGroup $group
                 */
            /* $studentID = [];
             if (count($studentList) > 0) {
                 foreach ($studentList as $student) {
                         $studentID[] = $student->getId();
                     }
                 $EventsResultFilter = $this->em->getFilters()->enable('EventsResultFilter');
                 $EventsResultFilter->setParameter('userRole', implode(',', $user->getRoles()));
                 $EventsResultFilter->setParameter('studentId', implode(",", $studentID));
             }*/

        }
    }
}