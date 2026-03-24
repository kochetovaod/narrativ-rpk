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
        Schema::create('equipment', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название оборудования');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание оборудования');
            $table->longText('content')->nullable()->comment('Подробное описание оборудования');
            $table->json('properties')->nullable()->comment('Характеристики оборудования в формате JSON');
            $table->enum('category', ['milling', 'laser', 'uv_print', 'wide_format', 'lamination'])->nullable();
            $table->string('manufacturer')->nullable()->comment('Производитель');
            $table->integer('year')->nullable()->comment('Год ввода в эксплуатацию');
            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение оборудования');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение оборудования');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность оборудования');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации оборудования');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'equipment_active_index');
            $table->index('sort', 'equipment_sort_index');
            $table->index('published_at', 'equipment_published_at_index');
            $table->index(['active', 'sort'], 'equipment_active_sort_index');

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

            $table->comment('Оборудование компании');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
