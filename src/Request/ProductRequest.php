<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Collection;


class ProductRequest
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateProductData(array $postData)
    {
        $constraints = new Collection([
            'category' => [
                new NotBlank()
            ],
            'priceLessThan' => [
                new Optional()
            ]
        ]);

        return $this->validator->validate($postData, $constraints);
    }
}