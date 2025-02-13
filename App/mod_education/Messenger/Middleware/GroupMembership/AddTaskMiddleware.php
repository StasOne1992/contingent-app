<?php

namespace App\mod_education\Messenger\Middleware\GroupMembership;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AddTaskMiddleware implements MiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        return $envelope;
    }
}