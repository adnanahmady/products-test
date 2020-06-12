<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Constants\ProductType as ProductTypeConstant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductType extends Model
{
    protected $fillable = [
        ProductTypeConstant::PRODUCT_ID,
        ProductTypeConstant::COLOR_ID,
        ProductTypeConstant::PRICE
    ];

    /**
     * product
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * products color
     *
     * @return BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
}
