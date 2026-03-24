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
        Schema::create('portfolio', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название портфолио');

            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание портфолио');
            $table->longText('content')->nullable()->comment('Подробное описание портфолио');
            $table->json('properties')->nullable()->comment('Характеристики портфолио в формате JSON');
            $table->unsignedBigInteger('client_id')->nullable()->comment('Клиент, заказавший работу');
            $table->timestamp('completed_at')->nullable()->comment('Дата выполнения работы');
            $table->decimal('budget', 15, 2)->nullable()->comment('Бюджет проекта');
            $table->string('address', 255)->nullable()->comment('Адрес объекта');
            $table->string('city', 255)->nullable()->comment('Город объекта');
            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение портфолио');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение портфолио');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность портфолио');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации портфолио');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'portfolio_active_index');
            $table->index('sort', 'portfolio_sort_index');
            $table->index('published_at', 'portfolio_published_at_index');
            $table->index(['active', 'sort'], 'portfolio_active_sort_index');
            $table->index('client_id', 'portfolio_client_id_index');
            // Внешние ключи
            $table->foreign('preview_id')
                ->references('id')
                ->on('attachments')
                ->onDelete('SET NULL');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
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

            $table->comment('портфолио компании');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};
