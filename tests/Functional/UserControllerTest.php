<?php
declare(strict_types=1);
namespace App\Tests\Functional;

use App\Service\UserFetcher;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private MockObject|UserFetcher $userFetcher;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userFetcher = $this->createMock(UserFetcher::class);
        $this->client = self::createClient();
    }

    public function testGetUsers()
    {
        $this->client->request('GET', '/aszende/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertIsArray($responseData);

        if (!empty($responseData)) {
            $this->assertArrayHasKey('id', $responseData[0]);
            $this->assertArrayHasKey('name', $responseData[0]);
            // I could test all the fields, for lack of time I won't :D disculpa
        }
    }

    public function testGetUsersError()
    {
        $userFetcherMock = $this->createMock(UserFetcher::class);
        $userFetcherMock
            ->expects($this->once())
            ->method('getUsers')
            ->will($this->throwException(new \Exception('Test exception')));

        self::getContainer()->set('App\Service\UserFetcher', $userFetcherMock);

        $this->client->request('GET', '/aszende/users');

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $this->client->getResponse()->getStatusCode());

        $this->assertTrue(
            $this->client->getResponse()->headers->contains('Content-Type', 'application/json'),
            'The content type is not JSON.'
        );

        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        // Assert that the response contains an error message
        $this->assertArrayHasKey('error', $responseData, 'The response does not contain an "error" field.');
        $this->assertEquals('Test exception', $responseData['error'], 'The error message is not correct.');
    }
}
