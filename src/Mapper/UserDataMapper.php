<?php
declare(strict_types=1);
namespace App\Mapper;

use App\Model\Address;
use App\Model\Company;
use App\Model\Geo;
use App\Model\User;

class UserDataMapper
{
    /**
     * @return User[]
     */
    public static function transform(array $data): array
    {
        $users = [];
        foreach ($data as $item) {
            $geo = new Geo((float) $item['address']['geo']['lat'], (float) $item['address']['geo']['lng']);
            $address = new Address($item['address']['street'], $item['address']['suite'], $item['address']['city'], $item['address']['zipcode'], $geo);
            $company = new Company($item['company']['name'], $item['company']['catchPhrase'], $item['company']['bs']);
            $users[] = new User($item['id'], $item['name'], $item['username'], $item['email'], $address, $item['phone'], $item['website'], $company);
        }

        return $users;
    }
}
