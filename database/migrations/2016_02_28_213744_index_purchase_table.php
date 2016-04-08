<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndexPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Adding a unique index between user id and stock id

        Schema::table('purchase', function ($table){

            $table->unique(['user_id', 'stock_id']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('purchase', function($table){
          // we really should drop the unique index here but i don't know how to
          //  $table->dropUnique('purchase_user_id_stock_id_unique');
        });
    }
}
