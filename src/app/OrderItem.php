<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Constants\OrderItem as OrderItemConstant;
use App\Constants\ProductType as ProductTypeConstant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        OrderItemConstant::COUNT,
        OrderItemConstant::ORDER_ID
    ];

    /**
     * the type of product that ordered
     *
     * @return BelongsTo
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, [
            ProductTypeConstant::PRODUCT_ID,
            ProductTypeConstant::COLOR_ID
        ]);
    }

    /**
     * items order category
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
