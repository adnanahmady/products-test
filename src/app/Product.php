<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Constants\Product as ProductConstant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Constants\ColorProduct;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * @return BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class)
                    ->withPivot(ColorProduct::PRICE)
                    ->withTimestamps();
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

    /**
     * filters query
     *
     * @param mixed $query
     * @param mixed $filter
     */
    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }
}
