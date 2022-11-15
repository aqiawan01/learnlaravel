<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->string('title');
            $table->string('slug');
            $table->string('availability', 100);
            $table->string('price', 100)->nullable();
            $table->string('rating', 100)->nullable();
            $table->string('publisher', 100)->nullable();
            $table->string('country_of_publisher', 100)->nullable();
            $table->string('isbn', 100)->nullable();
            $table->string('isbn-10', 100)->nullable();
            $table->string('audience', 100)->nullable();
            $table->string('recommended', 100)->nullable();
            $table->string('product_img');
            $table->text('description');
            $table->string('status');
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
        Schema::dropIfExists('product');
    }
}
