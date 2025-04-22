<?php

namespace App\mod_mosregvis\Service;

use App\mod_mosregvis\Entity\mosregApiConnection;
use Exception;
use Symfony\Component\HttpClient\Exception\JsonException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


/****
 *  Сервис используемый для работы с API MosregVis
 *
 */
class ModMosregApiConnectionInterfaceService
{
    private mosregApiConnection $apiConnection;
    private HttpClientInterface $client;

    public function __construct(mosregApiConnection $connection, HttpClientInterface $client)
    {
        $this->apiConnection = $connection;
        $this->client = $client;
    }
    public function auth(): void
    {
        try {
            $auth = $this->api_auth();
        } catch (\JsonException $e) {
            dd($e->getMessage());
        }
        if ($auth->getStatusCode() != 200) {
            throw new Exception('Ошибка авторизации в API "Зачисление в ПОО"');
        }
        $responseContent = json_decode($auth->getContent());
        $token = 'Token ' . $responseContent->token;
            $headers = $this->apiConnection->getApiHeaders();
        $headers['Authorization'] = $token;
            $this->apiConnection->setApiHeaders($headers);
        $this->apiConnection->setToken($token);

    }
    private function api_auth(): Response
    {
        try {
            $request = $this->client->request('POST', $this->apiConnection->getApiLoginUrl(),
                [
                    'headers' => $this->apiConnection->getApiHeaders(),
                    'body' => json_encode(
                        [
                            'username' => $this->apiConnection->getUsername(),
                            'password' => $this->apiConnection->getPassword()
                        ],
                        JSON_THROW_ON_ERROR)
                ]);
            return new Response($request->getContent(), $request->getStatusCode());
        } catch (JsonException|TransportExceptionInterface|ClientExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface $e) {
            return new Response($e, Response::HTTP_INTERNAL_SERVER_ERROR);

        }


    }
    public function check_api_auth(): Response
    {
        $response = $this->client->request('GET', $this->apiConnection->getApiCheckAuthenticatedUrl(), [
            'headers' => $this->apiConnection->getApiHeaders()
        ]);

        try {
            $i = $response->getStatusCode();
            if ($i == 401) {
                return new Response("UNAUTHORIZED", Response::HTTP_UNAUTHORIZED);
            } elseif ($i == 200) {
                return new Response("OK", Response::HTTP_OK);
            } else {
                return new Response($response->getContent(), $response->getStatusCode());
            }
        } catch (TransportExceptionInterface $e) {
            dump($e);
            return new Response($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            return new Response($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function init_from_api(): Response
    {
        try {
            $response = $this->client->request('GET', $this->apiConnection->getApiCheckAuthenticatedUrl(),
                [
                    'headers' => $this->apiConnection->getApiHeaders(),
                ]);
            return new Response($response->getContent(), $response->getStatusCode());
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            return new Response($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function get_org_info($org_id): Response
    {
        try {
            $response = $this->client->request('GET', $this->apiConnection->getApiUrl() . "/spoOrganization/{$org_id}",
                [
                    'headers' => $this->apiConnection->getApiHeaders(),
                ]);
            return new Response($response->getContent(), $response->getStatusCode());
        } catch (TransportExceptionInterface $e) {
            return new Response($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}