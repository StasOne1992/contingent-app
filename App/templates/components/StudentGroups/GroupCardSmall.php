<?php

namespace App\templates\components\StudentGroups;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class GroupCardSmall
{

    public string $groupName;
    public string $groupId;
    public int $groupMembersCount;
    public string $groupAvatarLink="/assets/media/avatars/avatar15.jpg";
}