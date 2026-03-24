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
        Schema::create('employees', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Имя сотрудника');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->json('properties')->nullable();

            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Фото сотрудника');
            $table->unsignedInteger('detail_id')->nullable();

            // Метаданные
            $table->integer('sort')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamp('published_at')->nullable();

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'employees_active_index');
            $table->index('sort', 'employees_sort_index');

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

            $table->comment('Клиенты компании');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
