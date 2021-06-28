<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");

            $table->foreign("user_id")->references("user_id")->on("users")
                  ->onUpdate("cascade")
                  ->onDelete("cascade");

            $table->string("product_id");

            $table->foreign("product_id")->references("product_id")->on("products")
                  ->onUpdate("cascade")
                  ->onDelete("cascade");
            
            $table->integer("quantity_product");
            $table->integer("price_product");
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
        Schema::dropIfExists('carts');
    }
}
