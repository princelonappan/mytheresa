<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\CommonService;

class CommonServiceTest extends TestCase
{
    public function testDiscounts()
    {
        $productArray = array(
            'sku' => '000003',
            'category' => 'boots'
        );
        $commonService = new CommonService();
        $discounts = $commonService->getDiscounts($productArray);
        $this->assertIsArray($discounts);
    }

    public function testCalculateDiscount()
    {
        $productArray = array(
            'sku' => '000003',
            'category' => 'boots',
            'price' => 1000
        );
        $discount = array(10, 20);
        $commonService = new CommonService();
        $discounts = $commonService->calculateDiscount($productArray, $discount);
        $this->assertIsArray($discounts);
    }
}