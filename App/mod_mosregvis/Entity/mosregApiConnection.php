<?php

namespace App\mod_mosregvis\Entity;

use phpDocumentor\Reflection\Types\This;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Token;
use function Symfony\Component\Translation\t;

/***
 * Создаёт объект соединение с API Зачисление в ПОО
 *
 *
 *
 * @version 0.1.0
 *
 */
class mosregApiConnection
{
    protected string $token;
    private string $collegeId;
    private string $yearId;
    private string $yearOrderId;
    private string $username;
    private string $password;
    private string $apiUrl;
    private string $apiLoginUrl;
    private string $apiSpoOrganisationUrl;
    private string $apiCheckAuthenticatedUrl;
    private string $apiAvailableUrl;
    private string $apiSpoPetitionListUrl;
    private string $apiSpoPetitionUrl;
    private array $apiHeaders;
    private int $admissionId;

    /**
     * @param ?string $token - Токен доступа полученный ранее
     * @param ?array $apiHeaders - Заголовки для HTTP запросов
     */

    public function __construct(
        ?string $token = '' ?? "",
        ?array  $apiHeaders = [])
    {
        $this->setApiUrl("https://prof.mo.mosreg.ru/api");
        $this->setApiAvailableUrl("https://prof.mo.mosreg.ru");
        $this->setApiCheckAuthenticatedUrl($this->getApiUrl() . '/check/authenticated');
        $this->setApiLoginUrl($this->getApiUrl() . '/login');
        $this->setApiSpoPetitionListUrl($this->getApiUrl() . '/spoPetition/search/advancedSearch');
        $this->setApiSpoPetitionUrl($this->getApiUrl() . '/spoPetition/');
        $this->setApiSpoOrganisationUrl("{$this->getApiUrl()}/spoOrganization/");
        $this->setApiHeaders([
            'Accept: */*',
            'Content-Type: application/json',
            'Cookie: Cookie_1=value']);
        if (!empty($apiHeaders)) $this->apiHeaders[] = $apiHeaders;
        if ($token != '') {
            $this->token = $token;
            $this->apiHeaders[] = "Authorization: {$token}";
        }
    }

    public function getApiConfiguration(): array
    {
        $config = [];
        $config['url']['base'] = $this->getApiUrl();
        $config['url']['login'] = $this->getApiLoginUrl();
        $config['url']['checkAuthenticated'] = $this->getApiCheckAuthenticatedUrl();
        $config['url']['available'] = $this->getApiAvailableUrl();
        $config['headers'] = $this->getApiHeaders();
        return $config;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->apiHeaders['Authorization'] = $token;
        $this->token = $token;
    }

    public function getCollegeId(): string
    {
        return $this->collegeId;
    }

    public function setCollegeId(string $collegeId): void
    {
        $this->collegeId = $collegeId;
    }

    public function getYearId(): string
    {
        return $this->yearId;
    }

    public function setYearId(string $yearId): void
    {
        $this->yearId = $yearId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getYearOrderId(): string
    {
        return $this->yearOrderId;
    }

    public function setYearOrderId(string $yearOrderId): void
    {
        $this->yearOrderId = $yearOrderId;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function setApiUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }

    public function getApiAvailableUrl(): string
    {
        return $this->apiAvailableUrl;
    }

    public function setApiAvailableUrl(string $apiAvailableUrl): void
    {
        $this->apiAvailableUrl = $apiAvailableUrl;
    }

    public function getApiHeaders(): array
    {
        return $this->apiHeaders;
    }

    public function getAdmissionId(): int
    {
        return $this->admissionId;
    }

    public function setAdmissionId(int $admissionId): void
    {
        $this->admissionId = $admissionId;
    }

    public function getApiLoginUrl(): string
    {
        return $this->apiLoginUrl;
    }

    public function setApiLoginUrl(string $apiLoginUrl): void
    {
        $this->apiLoginUrl = $apiLoginUrl;
    }

    public function setApiHeaders(array $apiHeaders): void
    {
        $this->apiHeaders = $apiHeaders;
    }

    public function getApiCheckAuthenticatedUrl(): string
    {
        return $this->apiCheckAuthenticatedUrl;
    }

    public function setApiCheckAuthenticatedUrl(string $apiCheckAuthenticatedUrl): void
    {
        $this->apiCheckAuthenticatedUrl = $apiCheckAuthenticatedUrl;
    }

    public function getApiSpoPetitionListUrl($params = []): string
    {

        return $this->apiSpoPetitionListUrl . $this->generateUrlParamsString($params);
    }

    public function setApiSpoPetitionListUrl(string $apiSpoPetitionListUrl): void
    {
        $this->apiSpoPetitionListUrl = $apiSpoPetitionListUrl;
    }

    public function getApiSpoPetitionUrl($id, $projection = 'detail'): string
    {
        return $this->apiSpoPetitionUrl . '/' . $id . '?projection=' . $projection;
    }

    public function setApiSpoPetitionUrl(string $apiSpoPetitionUrl): void
    {
        $this->apiSpoPetitionUrl = $apiSpoPetitionUrl;
    }

    public function generateUrlParamsString($params = []): string
    {
        $additionalString = '';

        if ($params) {
            foreach ($params as $key => $value) {
                if ($key === array_key_first($params)) {
                    $additionalString .= "?{$key}={$value}";
                } else if ($key === array_key_last($params)) {
                    $additionalString .= "{$key}={$value}";
                } else {
                    $additionalString .= "{$key}={$value}&";
                }
            }
        }
        return $additionalString;
    }

    public function getApiSpoOrganisationUrl(): string
    {
        return $this->apiSpoOrganisationUrl;
    }

    public function setApiSpoOrganisationUrl(string $apiSpoOrganisationUrl): void
    {
        $this->apiSpoOrganisationUrl = $apiSpoOrganisationUrl;
    }


}