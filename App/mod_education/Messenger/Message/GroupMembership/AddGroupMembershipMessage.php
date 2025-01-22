<?php

namespace App\mod_education\Messenger\Message\GroupMembership;

class AddGroupMembershipMessage
{
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }
    public function getContent(): string
    {
        return $this->content;
    }
}