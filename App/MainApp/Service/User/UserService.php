<?php

namespace App\MainApp\Service\User;

use App\MainApp\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private  UserPasswordHasherInterface $userPasswordHasher,

    )

    {
    }

    /**
     * @param string $plainPassword
     * @return string
     */
public function hashPassword(User $user,string $plainPassword):string
{
    $hashPassword='';
    if (!is_null($plainPassword)) {
        $hashPassword = $this->userPasswordHasher->hashPassword($user, $plainPassword);
    }
    else
    {
        $plainPassword=uniqid();
        $hashPassword = $this->userPasswordHasher->hashPassword($user, $plainPassword);
    }
    return $hashPassword;
}

}