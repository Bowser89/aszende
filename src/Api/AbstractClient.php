<?php
declare(strict_types=1);
namespace App\Api;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractClient
{
    public function __construct(
        protected readonly  HttpClientInterface $client,
        protected readonly string $apiUrl,
        protected readonly LoggerInterface $logger)
    {
    }
}
