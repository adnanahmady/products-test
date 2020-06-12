<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\Order;
use App\Constants\User;
use App\Traits\DropForeignKey;

class CreateOrdersTable extends Migration
{
    use DropForeignKey;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Order::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Order::USER_ID);
            $table->timestamps();

            $table->foreign(Order::USER_ID)
                  ->references(User::KEY)
                  ->on(User::TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropForeign(Order::TABLE, [Order::USER_ID]);

        Schema::dropIfExists(Order::TABLE);
    }
}
