<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use App\Service\CommonService;
use App\Request\ProductRequest;
use Nelmio\ApiDocBundle\Annotation\Security;

class ProductController extends AbstractController
{
    /**
     * @var CommonService
     */
    private $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /**
     * List products.
     *
     * @Route("/api/products", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns all the products",
     * )
     * @OA\Parameter(
     *     name="category",
     *     in="query",
     *     required=true,
     *     description="Category Name"
     * ),
     * @OA\Parameter(
     *     name="priceLessThan",
     *     in="query",
     *     description="Price range"
     * )
     * @OA\Tag(name="Product")
     * @Security(name="Bearer")
     */

    public function index(ProductService $productService, Request $request, ProductRequest $productRequest): Response
    {
        $parameters['category'] = $request->query->get('category');
        $parameters['priceLessThan'] = $request->query->get('priceLessThan');
        $validation = $productRequest->validateProductData($parameters);
        if (count($validation) > 0)
        {
            $errorsString = (string) $validation;
            return new Response($errorsString);
        }

        $products = $productService->getAllProducts();
        $categoryName = $parameters['category'];
        $priceLessThan = $parameters['priceLessThan'];
        $filteredProducts = array('No products found');
        $maxProducts = 5;
        $i = 0;
        foreach ($products as $product) {
            if (count($filteredProducts) >= $maxProducts)
                break;

            if ($product['category'] == $categoryName) {
                $discounts = $this->commonService->getDiscounts($product);
                if ((!empty($priceLessThan) && $priceLessThan > 0 && $product['price'] <= $priceLessThan)
                    || !isset($priceLessThan)) {
                    $filteredProducts[$i] = $product;
                    $filteredProducts[$i]['price'] = $this->commonService->calculateDiscount($product, $discounts);
                    $i++;
                }
            }
        }

        return $this->json($filteredProducts);
    }
}