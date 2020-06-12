<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\OrderItem;
use App\Traits\DropForeignKey;
use App\Constants\ColorProduct;
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
            $table->unsignedBigInteger(OrderItem::COLOR_PRODUCT_ID);
            $table->unsignedBigInteger(OrderItem::ORDER_ID);
            $table->timestamps();

            $table->unique([
                OrderItem::COLOR_PRODUCT_ID,
                OrderItem::ORDER_ID
            ]);

            $table->foreign(OrderItem::COLOR_PRODUCT_ID)
                  ->references(ColorProduct::KEY)
                  ->on(ColorProduct::TABLE);
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
            OrderItem::COLOR_PRODUCT_ID
        ]);

        Schema::dropIfExists(OrderItem::TABLE);
    }
}
