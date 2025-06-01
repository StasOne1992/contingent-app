<?php

namespace App\Security;

use App\MainApp\Entity\College;
use App\MainApp\Repository\CollegeRepository;

use App\mod_mosregvis\Entity\ModMosregVis_College;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{


    private RequestStack $requestStack;
    private CollegeRepository $collegeRepository;


    public function __construct(
        RequestStack      $requestStack,
        CollegeRepository $collegeRepository,

    )
    {
        $this->collegeRepository = $collegeRepository;
        $this->requestStack = $requestStack;

    }

    #[Route('/', name: 'app_sign_in')]
    public function app_sign_in(#[CurrentUser] ?User $user, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_secure');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@Security/auth/sign-in.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/sign-out', name: 'app_sign_out')]
    public function app_sign_out(): Response
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route(path: '/secure', name: 'app_secure')]
    public function indexAction()
    {
        /**
         * @var College $college
         */
        $college = $this->getUser()->getCollege();
        $session = $this->requestStack->getSession();
        $session->set('college', $college);

        $this->setMosregVisSessionParams($session);
        if ($this->isGranted('ROLE_ROOT')) {
            return $this->redirectToRoute('app_dashboard_index');
        }
        if ($this->isGranted('ROLE_STUDENT')) {
            return $this->redirectToRoute('app_student_dashboard');
        } else {
            return $this->redirectToRoute('app_dashboard_index');
        }

        throw new \Exception(AccessDeniedException::class);
    }

    private function setMosregVisSessionParams($session): void
    {
        $college = $this->getUser()->getCollege();
        if ($this->isGranted('ROLE_STAFF_AB_PETITIONS_VIS')) {
            $session->set('mosreg_vis_configuration', null);
            $session->set('mosreg_vis_college', null);
            $session->set('mosreg_vis_token', null);

            /**
             * @var ModMosregVis_College $mosregVisCollege
             */
            if (($mosregVisCollege = $college->getMosregVISCollege()) != null) {
                $session->set('mosreg_vis_college', $mosregVisCollege);
                if (($mosregVis = $mosregVisCollege->getModMosregVIS()->getValues()) != null) {
                    $session->set('mosreg_vis_configuration', $mosregVis[0]);
                }
            }
        }
        dump($session);
    }
}
