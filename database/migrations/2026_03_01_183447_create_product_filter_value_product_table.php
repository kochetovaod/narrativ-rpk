<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_filter_value_product', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('filter_value_id');

            $table->primary(['product_id', 'filter_value_id'], 'product_filter_value_primary');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('CASCADE');

            $table->foreign('filter_value_id')
                ->references('id')
                ->on('product_category_filter_values')
                ->onDelete('CASCADE');

            $table->comment('Связь продукта с выбранными значениями фильтров');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_filter_value_product');
    }
};
