<?php

namespace App\mod_education\Messenger\Middleware\GroupMembership;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AddGroupMembershipMessage implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        dump("AddGroupMembershipMessage");
        dump($envelope);
        dump("middleWare");
        dump('auditing!');
        //return $stack->next()->handle($envelope, $stack);
    }
}