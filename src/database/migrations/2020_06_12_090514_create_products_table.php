<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\DropForeignKey;
use App\Constants\Product;
use App\Constants\User;

class CreateProductsTable extends Migration
{
    use DropForeignKey;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Product::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(Product::NAME, 90);
            $table->text(Product::DESCRIPTION);
            $table->unsignedBigInteger(Product::USER_ID);
            $table->timestamps();

            $table->foreign(Product::USER_ID)
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
        $this->dropForeign(Product::TABLE, [Product::USER_ID]);

        Schema::dropIfExists(Product::TABLE);
    }
}
