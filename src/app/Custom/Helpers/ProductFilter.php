<?php

namespace App\Custom\Helpers;

use App\Custom\Helpers\Abstracts\Filter as AbstractFilter;
use App\Constants\Product;
use App\Constants\ColorProduct;

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
     * @param String $range
     *
     * @return void
     */
    protected function priceRange(String $range): void
    {
        $range = explode(',', $range);

        $this->builder
             ->with(['colors' => function ($query) use ($range) {
                 $query->wherePivotIn(
                     ColorProduct::COLOR_ID, 
                     function ($query) use ($range) {
                        return $query->select(ColorProduct::COLOR_ID)
                             ->from(ColorProduct::TABLE)
                             ->whereBetween(ColorProduct::PRICE, $range);
                     }
                 );
             }
        ])
        ->whereIn(
            Product::KEY,
            function ($query) use ($range) {
                return $query->select(ColorProduct::PRODUCT_ID)
                             ->from(ColorProduct::TABLE)
                             ->whereBetween(ColorProduct::PRICE, $range);
            }
        );
    }
}
