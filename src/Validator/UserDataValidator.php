<?php
declare(strict_types=1);
namespace App\Validator;

class UserDataValidator implements ValidatorInterface
{
    public function validate(array $data): bool
    {
        foreach ($data as $item) {
            if (!$this->validateItem($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string[] $item
     */
    public function validateItem(array $item): bool
    {
        if (!isset($item['id'], $item['name'], $item['username'],
            $item['email'], $item['address'], $item['phone'], $item['website'],
            $item['company'],$item['address']['geo']['lat'],
            $item['address']['geo']['lng'])) {
            return false;
        }

        return true;
    }
}
