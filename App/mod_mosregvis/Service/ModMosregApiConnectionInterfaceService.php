<?php

namespace App\mod_mosregvis\Service;

use App\mod_mosregvis\Entity\mosregApiConnection;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ModMosregApiConnectionInterfaceService
{
    private mosregApiConnection $apiConnection;
    private HttpClientInterface $client;

    public function __construct(mosregApiConnection $connection, HttpClientInterface $client)
    {
        $this->apiConnection = $connection;
        $this->client = $client;
    }

    public function auth()
    {
        $auth = $this->api_auth();
        if ($auth['status'] != 200) {
            throw new Exception($auth['content']);
        } else {
            $headers = $this->apiConnection->getApiHeaders();
            $headers['Authorization'] = 'Token ' . json_decode($auth['content'])->token;
            $this->apiConnection->setApiHeaders($headers);
            $this->apiConnection->setToken($auth['content']);
        }
    }

    private
    function api_auth()
    {
        $response = $this->client->request('POST', $this->apiConnection->getApiLoginUrl(),
            [
                'headers' => $this->apiConnection->getApiHeaders(),
                'body' => json_encode(
                    [
                        'username' => $this->apiConnection->getUsername(),
                        'password' => $this->apiConnection->getPassword()
                    ],
                    JSON_THROW_ON_ERROR)
            ]);

        $result['status'] = $response->getStatusCode();
        $result['content'] = '';
        if ($response->getStatusCode() == 200) {
            $result['content'] = (str_replace("\n", "", $response->getContent()));
        } else {
            $result['content'] = $response->getContent();
        }


        return $result;

    }

    public function init_from_api(): Response
    {
        $response = $this->client->request('GET', $this->apiConnection->getApiUrl() . '/check/authenticated',
            [
                'headers' => $this->apiConnection->getApiHeaders(),
            ]);

        if ($response->getStatusCode() != 200) {
            return new Response($response->getContent(), $response->getStatusCode());
        }
        return new Response($response->getContent(), $response->getStatusCode());

    }
}