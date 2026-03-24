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
        Schema::create('blogs', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название статьи');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание статьи');
            $table->longText('content')->nullable()->comment('Подробное описание статьи');
            $table->json('properties')->nullable()->comment('Характеристики статьи в формате JSON');
            $table->integer('views')->default(0)->comment('Количество просмотров статьи');
            $table->integer('likes')->default(0)->comment('Количество лайков статьи');
            $table->integer('time_read')->default(0)->comment('Время чтения статьи в минутах');
            // Категория статьи
            $table->unsignedBigInteger('category_id')->nullable()->comment('Категория статьи');
            $table->foreign('category_id')
                ->references('id')
                ->on('blog_categories')
                ->onDelete('SET NULL');

            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение статьи');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение статьи');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность статьи');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации статьи');

            // Автор статьи для отображения в блоге
            $table->unsignedBigInteger('author_id')->nullable()->comment('Автор статьи');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'blogs_active_index');
            $table->index('sort', 'blogs_sort_index');
            $table->index('published_at', 'blogs_published_at_index');
            $table->index(['active', 'sort'], 'blogs_active_sort_index');

            // Внешние ключи
            $table->foreign('author_id')
                ->references('id')
                ->on('employees')
                ->onDelete('SET NULL');

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

            $table->comment('Блог компании, статьи и новости');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
