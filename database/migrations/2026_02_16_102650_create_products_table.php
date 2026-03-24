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
        Schema::create('products', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название продукта');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание продукта');
            $table->longText('content')->nullable()->comment('Подробное описание продукта');
            $table->json('properties')->nullable()->comment('Характеристики продукта в формате JSON (те, что не идут в фильтр)');
            $table->unsignedBigInteger('category_id')->nullable();
            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение продукта');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение продукта');
            // Цена
            $table->decimal('price_from', 10, 2)->nullable()->comment('Цена от (в рублях)');
            $table->string('price_unit', 255)->unique()->nullable()->comment(' "м²", "буква", "шт"');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность продукта');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации продукта');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'products_active_index');
            $table->index('sort', 'products_sort_index');
            $table->index('published_at', 'products_published_at_index');
            $table->index(['active', 'sort'], 'products_active_sort_index');

            // Внешние ключи
            $table->foreign('preview_id')
                ->references('id')
                ->on('attachments')
                ->onDelete('SET NULL');

            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('SET NULL');

            $table->foreign('detail_id')
                ->references('id')
                ->on('attachments')
                ->onDelete('SET NULL');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->comment('продукция компании, ее ассортимент');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
