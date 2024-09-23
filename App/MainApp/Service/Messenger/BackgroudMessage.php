<?php

namespace App\MainApp\Service\Messenger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class BackgroudMessage
{
    public function __construct(
        private HubInterface    $hub,
    )
    {
    }

    public
    function push($topics, $type, $icon, $header, $message,): Response
    {
        $update = new Update(
            $topics,
            json_encode(['type' => $type, 'header' => $header, 'icon' => $icon, 'message' => $message]),
            //true
        );
        $this->hub->publish($update,);
        return new Response('published!');
    }
}