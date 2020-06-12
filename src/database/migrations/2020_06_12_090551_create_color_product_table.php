<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Product;
use App\Constants\Color;
use App\Traits\DropForeignKey;
use App\Constants\ColorProduct;

class CreateColorProductTable extends Migration
{
    use DropForeignKey;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ColorProduct::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(ColorProduct::PRODUCT_ID);
            $table->unsignedTinyInteger(ColorProduct::COLOR_ID);
            $table->unsignedInteger(ColorProduct::PRICE);
            $table->timestamps();

            $table->foreign(ColorProduct::PRODUCT_ID)
                  ->references(Product::KEY)
                  ->on(Product::TABLE);
            $table->foreign(ColorProduct::COLOR_ID)
                  ->references(Color::KEY)
                  ->on(Color::TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropForeign(ColorProduct::TABLE, [ColorProduct::PRODUCT_ID]);
        $this->dropForeign(ColorProduct::TABLE, [ColorProduct::COLOR_ID]);

        Schema::dropIfExists(ColorProduct::TABLE);
    }
}
