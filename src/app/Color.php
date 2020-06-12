<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Constants\Color as ColorConstant;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    protected $fillable = [
        ColorConstant::NAME,
        ColorConstant::HEX
    ];

    /**
     * products with the color
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
