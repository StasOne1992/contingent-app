<?php

namespace App\mod_mosregvis\Service;

use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ModMosregApiOpenService
{
    private HttpClientInterface $client;
    private string $ApiUrl = "http://prof.mo.mosreg.ru/api";
    private string $ApiAvailableUrl = "http://prof.mo.mosreg.ru";
    private array $ApiHeaders = ['Accept: */*', 'Content-Type: application/json', 'Cookie: Cookie_1=value'];

    public function __construct(
        HttpClientInterface $client
    )
    {
        $this->client = $client;
    }

    private function isApiAvailable(): bool
    {
        try {
            $response = $this->client->request('GET', $this->ApiAvailableUrl);
            if (200 == $response->getStatusCode()) {
                {
                    return true;
                }
            }
        } catch (TransportExceptionInterface $e) {
            throw new Exception(sprintf("Ошибка. API недоступно. Код ошибки:%s", $response->getStatusCode()));
        }
        return false;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws \JsonException
     * @throws TransportExceptionInterface
     */
    public function getOrgIdByUser($username, $password): string
    {
        try {
            if ($this->isApiAvailable()) {
                $response = $this->client->request('POST', $this->ApiUrl . '/login',
                    [
                        'headers' => ['Accept: */*', 'Content-Type: application/json', 'Cookie: Cookie_1=value'],
                        'body' => json_encode(
                            [
                                'username' => $username,
                                'password' => $password
                            ],
                            JSON_THROW_ON_ERROR)
                    ]);
            }
        } catch (\JsonException $e) {
        } catch (TransportExceptionInterface $e) {
        }
        if ($response->getStatusCode() != 200) {
            throw new Exception(sprintf("Ошибка получения токена авторизации к API. Код ошибки:%s", $response->getStatusCode()));
        }
        $Token = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR)['token'];
        if ($this->isApiAvailable()) {
            $response = $this->client->request('POST', $this->ApiUrl . '/check/authenticated',
                [
                    'headers' => array_merge($this->ApiHeaders, ['Authorization' => 'Token ' . $Token])
                ]);
        }
        if ($response->getStatusCode() != 200) {
            throw new Exception(sprintf("Ошибка получения данных организации из API. Код ошибки:%s", $response->getStatusCode()));
        } elseif ($response->getStatusCode() == 401) {
            throw new Exception("Ошибка авторизации API. Код ошибки: 401 Unauthorized ");
        }

        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR)['orgId'];
    }


}