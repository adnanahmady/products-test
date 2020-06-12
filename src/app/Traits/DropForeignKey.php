<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

trait DropForeignKey {
    /**
     * drops foreign key if environment is not testing
     * for testing environment it uses sqlite and 
     * sqlite does not drop foreign keys
     *
     * @param String $table
     * @param mixed $keys
     *
     * @return void
     */
    public function dropForeign(String $table, $keys): void
    {
        if (! app()->environment('testing')) {
            Schema::table(
                $table,
                function (Blueprint $table) use ($keys) {
                    $table->dropForeign($keys);
                }
            );
        }
    }
}
