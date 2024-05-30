<?php
declare(strict_types=1);
namespace App\Model;

class Geo
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lng
    ) {
    }
}
