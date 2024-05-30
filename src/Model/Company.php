<?php
declare(strict_types=1);
namespace App\Model;

class Company
{
    public function __construct(
        public readonly string $name,
        public readonly string $catchPhrase,
        public readonly string $bs
    ) {
    }
}
