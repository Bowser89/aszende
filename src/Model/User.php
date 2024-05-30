<?php
declare(strict_types=1);
namespace App\Model;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $username,
        public readonly string $email,
        public readonly Address $address,
        public readonly string $phone,
        public readonly string $website,
        public readonly Company $company
    ) {
    }
}
