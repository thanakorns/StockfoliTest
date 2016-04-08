<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PurchaseFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase', function($table){
            $table->foreign('stock_id')->references('id')->on('stock');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase', function($table) {
            $table->dropForeign('purchase_stock_id_foreign');
            $table->dropForeign('purchase_user_id_foreign');
        });
    }
}
