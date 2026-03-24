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
        Schema::create('services', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название услуги');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание услуги');
            $table->longText('content')->nullable()->comment('Подробное описание услуги');
            $table->json('properties')->nullable()->comment('Характеристики услуги в формате JSON');
            $table->json('process_steps')->nullable()->comment('Этапы работы');
            $table->string('guarantee')->nullable()->comment('Гарантия');
            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение услуги');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение услуги');
            // Цена
            $table->decimal('price_from', 10, 2)->nullable()->comment('Цена от (в рублях)');
            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность услуги');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации услуги');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'services_active_index');
            $table->index('sort', 'services_sort_index');
            $table->index('published_at', 'services_published_at_index');
            $table->index(['active', 'sort'], 'services_active_sort_index');

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

            $table->comment('услуги компании');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
