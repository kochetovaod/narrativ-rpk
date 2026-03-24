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
        Schema::create('settings', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Ключ-значение
            $table->string('key', 255)->unique()->comment('Уникальный ключ настройки');
            $table->text('value')->nullable()->comment('Значение настройки');

            // Тип данных
            $table->enum('type', ['string', 'text', 'integer', 'boolean', 'json', 'color', 'image'])
                ->default('string')
                ->comment('Тип значения');

            // Группа настроек
            $table->string('group', 100)->default('general')->comment('Группа: general, contacts, social, seo, telegram, email, design, notifications');

            // Описание
            $table->text('description')->nullable()->comment('Пояснение для админа');

            // Timestamps
            $table->timestamps();
            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');
            // Индексы
            $table->index('key', 'settings_key_index');
            $table->index('group', 'settings_group_index');

            $table->comment('Глобальные настройки сайта');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
