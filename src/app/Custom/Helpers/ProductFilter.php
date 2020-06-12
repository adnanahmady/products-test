<?php

namespace App\Custom\Helpers;

use App\Custom\Helpers\Abstracts\Filter as AbstractFilter;
use App\Constants\Product;
use App\Constants\ProductType;

class ProductFilter extends AbstractFilter {
    protected $filters = [
        'name',
        'price_range'
    ];

    /**
     * filters rows of data based on
     * givin name
     *
     * @param String $name
     *
     * @return void
     */
    protected function name(String $name): void
    {
        $this->builder->where(Product::NAME, 'LIKE', "%$name%");
    }

    /**
     * returns products within the range
     *
     * @param Array $range
     *
     * @return void
     */
    protected function priceRange(Array $range): void
    {
        $this->builder->whereIn(
            'id',
            function ($query) use ($range) {
                return $query->select('product_id')
                             ->from(ProductType::TABLE)
                             ->whereBetween(ProductType::PRICE, $range);
            }
        );
    }
}
