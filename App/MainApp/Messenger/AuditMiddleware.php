<?php

namespace App\MainApp\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AuditMiddleware implements MiddlewareInterface
{

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $context = ['class' => get_class($envelope->getMessage())];
        /*if ($envelope->last(ReceivedStamp::class)) {
            dump('Received ', $context);
        }
        elseif ($envelope->last(SentStamp::class)) {
            dump('Sending ', $context);
        }
        elseif($envelope->last(HandledStamp::class))
        {
            dump('Handling ', $envelope->getMessage());
        }*/
        return $stack->next()->handle($envelope, $stack);
    }


}