<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Constants\Product as ProductConstant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        ProductConstant::NAME,
        ProductConstant::DESCRIPTION,
        ProductConstant::USER_ID
    ];

    /**
     * product colors and prices
     *
     * @return HasMany
     */
    public function productTypes(): HasMany
    {
        return $this->hasMany(ProductType::class);
    }

    /**
     * the user who is selling product
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }
}
