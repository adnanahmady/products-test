<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\ProductType;
use App\Constants\Product;
use App\Constants\Color;
use App\Traits\DropForeignKey;

class CreateProductTypesTable extends Migration
{
    use DropForeignKey;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ProductType::TABLE, function (Blueprint $table) {
            $table->unsignedBigInteger(ProductType::PRODUCT_ID);
            $table->unsignedTinyInteger(ProductType::COLOR_ID);
            $table->unsignedInteger(ProductType::PRICE);
            $table->timestamps();
            $table->primary([
                ProductType::PRODUCT_ID,
                ProductType::COLOR_ID
            ]);

            $table->foreign(ProductType::PRODUCT_ID)
                  ->references(Product::KEY)
                  ->on(Product::TABLE);
            $table->foreign(ProductType::COLOR_ID)
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
        $this->dropForeign(ProductType::TABLE, [ProductType::PRODUCT_ID]);
        $this->dropForeign(ProductType::TABLE, [ProductType::COLOR_ID]);

        Schema::dropIfExists(ProductType::TABLE);
    }
}
