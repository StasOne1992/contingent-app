<?php

namespace App\Security;

use App\MainApp\Repository\ApiTokenRepository;
use App\MainApp\Security\BadCredentialsException;
use App\MainApp\Security\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class ApiTokenHandler implements AccessTokenHandlerInterface
{

    private ApiTokenRepository $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }
    /**
     * @inheritDoc
     */
    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {
        $token = $this->apiTokenRepository->findOneBy(['token' => $accessToken]);
        if (!$token) {
            throw new BadCredentialsException();
        }
        if (!$token->isValid()) {
            throw new CustomUserMessageAuthenticationException('Token expired');
        }
        return new UserBadge($token->getOwnedBy()->getUserIdentifier());
    }
}