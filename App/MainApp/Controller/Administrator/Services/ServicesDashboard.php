<?php

namespace App\MainApp\Controller\Administrator\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/administrator/services')]
#[IsGranted("ROLE_ROOT")]
class ServicesDashboard extends AbstractController
{
    public function __construct(
        private array $Services = array(),
    )
    {
        $this->Services[] = $this->constructService('SuperVisor Service','supervisor','ServiceAddCommand_1','supervisorctl status');
    }

    private function constructService($serviceTitle,$serviceSystemName,$serviceCurrentStatusCommandName,$serviceAddCommand_1='',$serviceAddCommand_2='',$serviceAddCommand_3=''): array
    {
        $serviceStartCommand = ['service', $serviceSystemName, 'start'];
        $serviceStopCommand = ['service', $serviceSystemName, 'start'];
        $serviceStatusCommand = ['service', $serviceSystemName, 'status'];


        $result['Title'] = $serviceTitle;
        $result['SystemName'] = $serviceSystemName;
        $result['ServiceStartCommand'] = $serviceStartCommand;
        $result['ServiceStopCommand'] = $serviceStopCommand;
        $result['ServiceStatusCommand'] = $serviceStatusCommand;
        $result['ServiceAddCommand_1']=$serviceAddCommand_1;
        $result['ServiceAddCommand_2']=$serviceAddCommand_2;
        $result['ServiceAddCommand_3']=$serviceAddCommand_3;
        //$result[$serviceCurrentStatusCommandName];
        $result['ServiceCurrentState']=$this->runCommandPrivate($result[$serviceCurrentStatusCommandName]);
        return $result;
    }


    #[Route('/', name: 'app_services_dashboard_index', methods: ['GET'])]
    #[IsGranted("ROLE_ROOT")]
    public function index(): Response
    {

        return $this->render('administrator/services/index.html.twig',
            [
                'services' => $this->Services,
            ]);
    }

    #[Route('/{command}/run', name: 'app_services_run_command', methods: ['GET'])]
    #[IsGranted("ROLE_ROOT")]
    public function runCommand(Request $request): Response
    {
        $command=$request->get('command');
        return new Response($this->serviceSendCommand($command));
    }

    private function runCommandPrivate($command)
    {
        return $this->serviceSendCommand($command);
    }

    private function serviceSendCommand($command)
    {
        $command=explode(" ",$command);
        $process = new Process($command);
        $process->run();
        if (!$process->isSuccessful()) {
            return $process->getOutput();
            //throw new ProcessFailedException($process);
        }
        return $process->getOutput();
    }

}