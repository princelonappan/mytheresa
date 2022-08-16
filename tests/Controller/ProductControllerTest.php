<?php

namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private $client;
    private $baseUrl;

    public function setUp(): void
    {
        $this->baseUrl = getenv('TEST_BASE_URL');
        $this->client = static::createClient();
    }

    public function testAPIRequestValidation(): void
    {
        $this->client->request('GET', $this->baseUrl . '/api/products');
        $message = $this->client->getResponse()->getContent();
        $this->assertStringContainsString('This value should not be blank', $message);
    }

    public function testAPIWithCategory(): void
    {
        $this->client->request('GET', $this->baseUrl . '/api/products?category=boots');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertCount(5, $data);
    }

    public function testAPIWithPriceLessWithZero(): void
    {
        $this->client->request('GET', $this->baseUrl . '/api/products?category=boots&priceLessThan=0');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertNotEmpty($data);
        $this->assertStringContainsString('No products found', $data[0]);
    }

    public function testAPIWithPriceLessWithValue(): void
    {
        $this->client->request('GET', $this->baseUrl . '/api/products?category=boots&priceLessThan=10000');
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertNotEmpty($data);
    }

}