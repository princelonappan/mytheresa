<?php

namespace App\Service;

class CommonService
{
    public function getDiscounts($product): array
    {
        $discounts = array();
        if ($product['sku'] == '000003') {
            $discounts[] = 15;
        }

        if ($product['category'] == 'boots') {
            $discounts[] = 30;
        }

        return $discounts;
    }

    public function calculateDiscount($product, $discounts): array
    {
        $originalPrice = $product['price'];
        $discountPrice = $originalPrice;
        $discount = 'null';
        if (!empty($discounts)) {
            rsort($discounts);
            $discount = $discounts[0];
            if ($discount > 0) {
                $discountPrice = $originalPrice - ($originalPrice * $discount / 100);
            }
        }

        return array(
            'original' => $originalPrice,
            'final' => $discountPrice,
            'discount_percentage' => $discount > 0 ? $discount . '%' : $discount,
            'currency' => 'EUR'
        );
    }
}
