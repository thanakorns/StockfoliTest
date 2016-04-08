<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StockUniqueTicker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('stock', function ($table) {

           // $table->unique('ticker');

        });

        /**
         * Reverse the migrations.
         *
         * @return void
         */

    }
    public function down()
    {
        //
        Schema::table('purchase', function($table){
            // we really should drop the unique index here but i don't know how to
            //  $table->dropUnique('purchase_user_id_stock_id_unique');
        });
    }
}
