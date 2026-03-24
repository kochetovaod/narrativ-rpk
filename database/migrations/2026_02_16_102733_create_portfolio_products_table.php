<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolio_products', function (Blueprint $table) {
            // Ключи
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('product_id');

            // Дополнительные поля (если нужны)
            $table->integer('sort')->default(0)->comment('Порядок в списке');
            $table->timestamps();

            // Первичный составной ключ
            $table->primary(['portfolio_id', 'product_id'], 'portfolio_product_primary');

            // Индексы
            $table->index('portfolio_id', 'pwd_portfolio_id_index');
            $table->index('product_id', 'pwd_product_id_index');
            $table->index('sort', 'pwd_sort_index');

            // Внешние ключи
            $table->foreign('portfolio_id')
                ->references('id')
                ->on('portfolio')
                ->onDelete('CASCADE');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_products');
    }
};
