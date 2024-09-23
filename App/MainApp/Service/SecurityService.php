<?php
namespace App\MainApp\Service;

use Symfony\Bundle\SecurityBundle\Security;


class SecurityService
{
private $security;

public function __construct(Security $security)
{
// Avoid calling getUser() in the constructor: auth may not
// be complete yet. Instead, store the entire Security object.
$this->security = $security;
}

public function UserGet()
{
// returns User object or null if not authenticated
$user = $this->security->getUser();

// ...
}
}
