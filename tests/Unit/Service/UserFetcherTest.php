<?php
declare(strict_types=1);
namespace App\Tests\Unit\Service;

use App\Api\JsonUserApiClient;
use App\Model\User;
use App\Service\UserFetcher;
use App\Validator\Exception\ValidationException;
use App\Validator\ValidatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * @coversDefaultClass \App\Service\UserFetcher
 */
class UserFetcherTest extends TestCase
{
    private JsonUserApiClient|MockObject $client;

    private ValidatorInterface|MockObject $userDataValidator;

    private UserFetcher $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createMock(JsonUserApiClient::class);
        $this->userDataValidator = $this->createMock(ValidatorInterface::class);
        $this->userService = new UserFetcher($this->client, $this->userDataValidator);
    }

    /**
     * @covers ::getUsers
     */
    public function testGetUsers()
    {
        $users = $this->generateMockResponse();

        $this->client
            ->expects($this->once())
            ->method('fetchUsers')
            ->willReturn($users);

        $this->userDataValidator
            ->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        /** @var User[] $data */
        $data = $this->userService->getUsers();

        $this->assertCount(1, $data);
        $this->assertInstanceOf(User::class, $data[0]);
        $this->assertEquals('Leanne Graham', $data[0]->name);
    }

    public function testGetUsersWithInvalidData()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed for API data');

        $users = $this->generateMockResponse();
        $this->client
            ->expects($this->once())
            ->method('fetchUsers')
            ->willReturn($users);

        $this->userDataValidator
            ->expects($this->once())
            ->method('validate')
            ->willReturn(false);

        $this->userService->getUsers();
    }

    private function generateMockResponse(): array
    {
        return
            [
                [
                    'id' => 1,
                    'name' => 'Leanne Graham',
                    'username' => 'Bret',
                    'email' => 'Sincere@april.biz',
                    'address' => [
                        'street' => 'Kulas Light',
                        'suite' => 'Apt. 556',
                        'city' => 'Gwenborough',
                        'zipcode' => '92998-3874',
                        'geo' => ['lat' => '-37.3159', 'lng' => '81.1496'],
                    ],
                    'phone' => '1-770-736-8031 x56442',
                    'website' => 'hildegard.org',
                    'company' => [
                        'name' => 'Romaguera-Crona',
                        'catchPhrase' => 'Multi-layered client-server neural-net',
                        'bs' => 'harness real-time e-markets',
                    ],
                ],
        ];
    }

    private function generateMissingFieldsMockResponse(): MockResponse
    {
        return new MockResponse(json_encode([
            [
                'name' => 'Leanne Graham',
                'username' => 'Bret',
                'email' => 'Sincere@april.biz',
                'address' => [
                    'street' => 'Kulas Light',
                    'suite' => 'Apt. 556',
                    'city' => 'Gwenborough',
                    'zipcode' => '92998-3874',
                    'geo' => ['lat' => '-37.3159', 'lng' => '81.1496'],
                ],
                'phone' => '1-770-736-8031 x56442',
                'website' => 'hildegard.org',
                'company' => [
                    'name' => 'Romaguera-Crona',
                    'catchPhrase' => 'Multi-layered client-server neural-net',
                    'bs' => 'harness real-time e-markets',
                ],
            ],
        ]));
    }
}
