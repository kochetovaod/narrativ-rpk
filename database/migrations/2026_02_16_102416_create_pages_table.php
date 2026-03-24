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
        Schema::create('pages', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название страницы');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание страницы');
            $table->longText('content')->nullable()->comment('Подробное описание страницы');
            $table->json('properties')->nullable()->comment('Характеристики страницы в формате JSON');

            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение страницы');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение страницы');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность страницы');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации страницы');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'pages_active_index');
            $table->index('sort', 'pages_sort_index');
            $table->index('published_at', 'pages_published_at_index');
            $table->index(['active', 'sort'], 'pages_active_sort_index');

            // Внешние ключи
            $table->foreign('preview_id')
                ->references('id')
                ->on('attachments')
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

            $table->comment('страницы сайта');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
