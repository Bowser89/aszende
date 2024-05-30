<?php
declare(strict_types=1);
namespace App\Model;

class Address
{
    public function __construct(
        public readonly string $street,
        public readonly string $suite,
        public readonly string $city,
        public readonly string $zipcode,
        public readonly Geo $geo)
    {
    }
}
