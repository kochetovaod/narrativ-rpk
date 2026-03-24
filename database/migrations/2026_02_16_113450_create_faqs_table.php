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
        Schema::create('faqs', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название вопроса');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание вопроса');
            $table->longText('content')->nullable()->comment('Подробное описание вопроса');
            $table->json('properties')->nullable()->comment('Характеристики вопроса в формате JSON');
            $table->unsignedBigInteger('category_id')->nullable();
            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение вопроса');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение вопроса');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность вопроса');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации вопроса');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'faqs_active_index');
            $table->index('sort', 'faqs_sort_index');
            $table->index('published_at', 'faqs_published_at_index');
            $table->index(['active', 'sort'], 'faqs_active_sort_index');

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

            $table->foreign('category_id')
                ->references('id')
                ->on('faq_categories')
                ->onDelete('SET NULL');

            $table->comment('вопросы из раздела FAQ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
