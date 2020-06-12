<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\Constants\Product as ProductConstant;
use App\Constants\ProductType as ProductTypeConstant;
use App\ProductType;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function products_must_be_shown()
    {
        $this->withoutExceptionHandling();
        $products = factory(Product::class, 3)->create();

        $response = $this->get(route('products'));
        $response->assertStatus(200);

        $products->map(function ($product) use ($response) {
            $this->assertStringContainsString(
                $product->{ProductConstant::NAME},
                $response->getContent()
            );
        });
    }

    /** @test */
    public function products_must_be_searchable_using_their_name()
    {
        $this->withoutExceptionHandling();
        $products = factory(Product::class, 2)->create();

        $response = $this->get(route('products', [
            'name' => $products->first()->{ProductConstant::NAME}
        ]));
        $response->assertStatus(200);

        $this->assertStringContainsString(
            $products->first()->{ProductConstant::NAME},
            $response->getContent()
        );

        $this->assertStringNotContainsString(
            $products->last()->{ProductConstant::NAME},
            $response->getContent()
        );
    }

    /** @test */
    public function products_must_be_searchable_using_price_range()
    {
        $this->withoutExceptionHandling();
        $prices = [10000, 17000, 25000, 18000];
        foreach ($prices as $price) {
            $productTypes[] = factory(ProductType::class)->create([
                'price' => $price
            ]);
        }

        $response = $this->get(route('products', [
            'price_range' => [1000, 15000]
        ]));
        $response->assertStatus(200);

        $this->assertStringContainsString(
            array_shift($productTypes)->{ProductTypeConstant::PRICE},
            $response->getContent()
        );

        array_map(function ($productType) use ($response) {
            $this->assertStringNotContainsString(
                $productType->{ProductTypeConstant::PRICE},
                $response->getContent()
            );
        }, $productTypes);
    }
}
