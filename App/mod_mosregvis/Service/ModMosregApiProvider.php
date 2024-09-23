<?php

namespace App\mod_mosregvis\Service;

use App\mod_mosregvis\Entity\mosregApiConnection;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ModMosregApiProvider
{
    protected mosregApiConnection $apiConnection;
    protected HttpClientInterface $client;

    public function __construct(mosregApiConnection $apiConnection, HttpClientInterface $client)
    {
        $this->client = $client;
        $this->apiConnection = $apiConnection;
    }

    protected function isApiAvailable(): bool
    {
        try {
            $response = $this->client->request('GET', $this->apiConnection->getApiAvailableUrl());
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
    public function getPetitionList()
    {
        $url = 'http://prof.mo.mosreg.ru/api/spoPetition/search/advancedSearch?page=0&size=5000&order=asc&projection=grid&q={"spoEducationYear":"6"}';
    }

}