<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ProductService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function getAllProducts()
    {
        $projectRoot = $this->params->get('kernel.project_dir');
        $path = $projectRoot . '/src/Entity/Products.json';
        $contents = file_get_contents($path);
        $products = json_decode($contents, true);
        return $products['products'];
    }
}
