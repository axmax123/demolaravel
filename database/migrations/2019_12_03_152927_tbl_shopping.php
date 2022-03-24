<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblShopping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_shopping', function (Blueprint $table) {
            $table->Increments('shopping_id');
            $table->String('shopping_name');  
            $table->integer('customer_id');
            $table->String('shopping_address');
            $table->String('shopping_phone');
            $table->String('shopping_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_shopping');
    }
}
