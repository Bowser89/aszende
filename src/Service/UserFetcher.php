<?php
declare(strict_types=1);
namespace App\Service;

use App\Api\AbstractClient;
use App\Mapper\UserDataMapper;
use App\Model\User;
use App\Validator\Exception\ValidationException;
use App\Validator\ValidatorInterface;

class UserFetcher
{
    public function __construct(
        private readonly AbstractClient $apiClient,
        private readonly ValidatorInterface $validator,
    ) {
    }

    /**
     * @return User[]
     *
     * @throws \Exception
     */
    public function getUsers(): array
    {
        $data = $this->apiClient->fetchUsers();

        if (!$this->validator->validate($data)) {
            throw new ValidationException('Validation failed for API data');
        }

        return UserDataMapper::transform($data);
    }
}
