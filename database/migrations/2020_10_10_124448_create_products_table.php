<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'fk_products_category_id')
                ->on('categories')
                ->references('id')
                ->onDelete('SET NULL');
            $table->string('title');
            $table->text('description')->nullable()->default(null);
            $table->unsignedInteger('price')->default(0);
            $table->unsignedMediumInteger('quantity')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
