<?php
namespace App\Api;

use App\Api\Exception\ClientException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class JsonUserApiClient extends AbstractClient
{
    public function __construct(HttpClientInterface $client, string $apiUrl, LoggerInterface $logger)
    {
        parent::__construct($client, $apiUrl, $logger);
    }

    public function fetchUsers(): array
    {
        try {
            $response = $this->client->request(Request::METHOD_GET, $this->apiUrl);

            return $response->toArray();
        } catch (\Exception $e) {
            $this->logger->error('Error fetching data from API: ' . $e->getMessage());

            throw new ClientException('Error with API client. Please check the logs.');
        }
    }
}
