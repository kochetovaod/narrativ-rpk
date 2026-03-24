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
        Schema::create('site_statistics', function (Blueprint $table) {
            $table->id();

            // Тип события
            $table->enum('event_type', [
                'page_view',      // просмотр страницы
                'unique_visit',   // уникальный посетитель
                'form_submit',    // отправка формы
                'phone_click',    // клик по телефону
            ])->comment('Тип события');

            // Источник события
            $table->string('page_url', 500)->nullable()->comment('URL страницы');
            $table->string('referrer', 500)->nullable()->comment('Источник перехода');

            // UTM-метки (для анализа рекламных кампаний)
            $table->string('utm_source', 255)->nullable();
            $table->string('utm_medium', 255)->nullable();
            $table->string('utm_campaign', 255)->nullable();

            // Данные посетителя
            $table->string('session_id', 100)->nullable()->comment('ID сессии');
            $table->string('ip_hash', 64)->nullable()->comment('Хэш IP для анонимности');
            $table->string('user_agent', 500)->nullable();
            $table->string('device_type', 20)->nullable()->comment('desktop/mobile/tablet');
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();

            // География (опционально — можно получить по IP через сервисы типа MaxMind)
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();

            // Метаданные
            $table->json('metadata')->nullable()->comment('Дополнительные данные (для form_submit — тип формы)');
            $table->timestamp('recorded_at')->useCurrent()->comment('Дата события');
            $table->integer('time_on_page')->nullable(); // Время на странице (секунды)
            $table->integer('scroll_depth')->nullable(); // Глубина прокрутки в %
            // Индексы
            $table->index(['event_type', 'recorded_at']);
            $table->index('page_url');
            $table->index('session_id');
            $table->index('recorded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_statistics');
    }
};
