<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\OrderItem;
use App\Traits\DropForeignKey;
use App\Constants\ProductType;
use App\Constants\Order;

class CreateOrderItemsTable extends Migration
{
    use DropForeignKey;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(OrderItem::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger(OrderItem::COUNT);
            $table->unsignedBigInteger(ProductType::PRODUCT_ID);
            $table->unsignedBigInteger(ProductType::COLOR_ID);
            $table->unsignedBigInteger(OrderItem::ORDER_ID);
            $table->timestamps();

            $table->foreign([
                    ProductType::PRODUCT_ID,
                    ProductType::COLOR_ID
                ])
                ->references([
                    ProductType::PRODUCT_ID,
                    ProductType::COLOR_ID
                ])
                ->on(ProductType::TABLE);
            $table->foreign(OrderItem::ORDER_ID)
                  ->references(Order::KEY)
                  ->on(Order::TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropForeign(OrderItem::TABLE, [
            ProductType::PRODUCT_ID,
            ProductType::COLOR_ID
        ]);

        Schema::dropIfExists(OrderItem::TABLE);
    }
}
