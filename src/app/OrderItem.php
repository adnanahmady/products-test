<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Constants\OrderItem as OrderItemConstant;
use App\Constants\ColorProduct as ColorProductConstant;
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
        return $this->belongsTo(ColorProduct::class, [
            ColorProductConstant::PRODUCT_ID,
            ColorProductConstant::COLOR_ID
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
