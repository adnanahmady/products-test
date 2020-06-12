<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\Constants\Product as ProductConstant;
use App\Constants\ColorProduct as ColorProductConstant;
use App\Color;

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
        $products = array_map(function ($price) {
            $product = factory(Product::class)->create();
            $product->colors()->attach(
                factory(Color::class)->create()->id,
                [ColorProductConstant::PRICE => $price]
            );

            return $product;
        }, $prices);

        $response = $this->get(route('products', [
            'price_range' => "15000,17400"
        ]));
        $response->assertStatus(200);

        $this->assertStringContainsString(
            $products[1]
                ->colors
                ->first()
                ->pivot
                ->{ColorProductConstant::PRICE},
            $response->getContent()
        );
        unset($products[1]);

        array_map(function ($product) use ($response) {
            $this->assertStringNotContainsString(
                $product
                    ->colors
                    ->first()
                    ->pivot
                    ->{ColorProductConstant::PRICE},
                $response->getContent()
            );
        }, $products);
    }

    /** @test */
    public function only_products_colors_that_are_in_range_must_return()
    {
        $this->withoutExceptionHandling();
        $prices = [10000, 17000, 25000, 18000];
        $product = factory(Product::class)->create();
        
        array_map(function ($price) use ($product) {
            $product->colors()->attach(
                factory(Color::class)->create()->id,
                [ColorProductConstant::PRICE => $price]
            );
        }, $prices);

        $response = $this->get(route('products', [
            'price_range' => "15000,17400"
        ]));
        $response->assertStatus(200);

        (function ($colors, $response) {
            $this->assertStringContainsString(
                    $colors[1]
                    ->pivot
                    ->{ColorProductConstant::PRICE},
                $response
            );
            unset($colors[1]);

            $colors->each(function ($color) use ($response) {
                $this->assertStringNotContainsString(
                        $color
                        ->pivot
                        ->{ColorProductConstant::PRICE},
                    $response
                );
            });
        })($product->colors, $response->getContent());
    }
}
