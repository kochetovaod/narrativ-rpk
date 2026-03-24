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
        Schema::create('leads', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Уникальный номер заявки для клиента
            $table->string('lead_number', 50)->unique()->nullable()->comment('Уникальный номер заявки (например, LEAD-2024-0001)');

            // Контактные данные
            $table->string('name', 255)->comment('Имя клиента');
            $table->string('phone', 20)->comment('Телефон (с маской)');
            $table->string('email', 255)->nullable()->comment('Email (опционально)');
            $table->string('company_name', 255)->nullable()->comment('Название компании (для B2B)');
            $table->string('position', 255)->nullable()->comment('Должность');

            // Дополнительные контакты
            $table->string('telegram', 255)->nullable()->comment('Telegram username');
            $table->string('whatsapp', 20)->nullable()->comment('WhatsApp номер');
            $table->string('preferred_contact', 50)->default('phone')->comment('Предпочтительный способ связи: phone, email, telegram, whatsapp');

            // Тип запроса
            $table->string('request_type', 100)->comment('Тип формы: calculate, callback, question, order, consultation');
            $table->string('service_type', 255)->nullable()->comment('Выбранная услуга/продукт из списка');

            // Связанные сущности
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('portfolio_id')->nullable()->comment('Связанный проект из портфолио');
            $table->unsignedBigInteger('client_id')->nullable()->comment('Связанный клиент (если уже есть в CRM)');

            // Сообщение и детали
            $table->text('message')->nullable()->comment('Описание задачи / вопрос');
            $table->json('form_data')->nullable()->comment('Полные данные формы в JSON');

            // Бюджет и сроки
            $table->decimal('budget_from', 15, 2)->nullable()->comment('Примерный бюджет от');
            $table->decimal('budget_to', 15, 2)->nullable()->comment('Примерный бюджет до');
            $table->date('desired_date')->nullable()->comment('Желаемая дата выполнения/связи');
            $table->time('desired_time')->nullable()->comment('Желаемое время для звонка');

            // Расширенный статус
            $table->enum('status', [
                'new',              // Новая
                'assigned',          // Назначена менеджеру
                'in_progress',       // В работе
                'waiting',           // Ожидание ответа клиента
                'qualified',         // Квалифицирован (теплый)
                'unqualified',       // Неквалифицирован (холодный)
                'converted',         // Конвертирован в сделку/клиента
                'closed',            // Закрыта (успешно)
                'lost',              // Проиграна (не успешно)
                'spam',               // Спам
            ])->default('new')->comment('Статус заявки');

            // Приоритет
            $table->enum('priority', [
                'low',               // Низкий
                'medium',            // Средний
                'high',              // Высокий
                'urgent',             // Срочно
            ])->default('medium')->comment('Приоритет обработки');

            // Источник
            $table->string('source', 100)->nullable()->comment('Источник: website, call, email, referral, social, etc.');
            $table->string('campaign', 255)->nullable()->comment('Рекламная кампания');

            // Назначение и обработка
            $table->unsignedBigInteger('assigned_to')->nullable()->comment('Ответственный менеджер');
            $table->unsignedBigInteger('processed_by')->nullable()->comment('Кто обработал');
            $table->timestamp('processed_at')->nullable()->comment('Дата обработки');
            $table->timestamp('assigned_at')->nullable()->comment('Дата назначения');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            // Коммуникации
            $table->timestamp('called_at')->nullable()->comment('Когда последний раз звонили');
            $table->timestamp('next_call_at')->nullable()->comment('Запланированный следующий звонок');
            $table->integer('call_attempts')->default(0)->comment('Количество попыток дозвона');

            // Результаты
            $table->text('manager_notes')->nullable()->comment('Заметки менеджера');
            $table->json('communication_history')->nullable()->comment('История коммуникаций в JSON');
            $table->string('loss_reason', 500)->nullable()->comment('Причина проигрыша/отказа');

            // Конверсия
            $table->timestamp('converted_at')->nullable()->comment('Дата конвертации в клиента');
            $table->unsignedBigInteger('converted_to_client_id')->nullable()->comment('ID созданного клиента');
            $table->unsignedBigInteger('converted_to_deal_id')->nullable()->comment('ID созданной сделки');

            // Техническая информация
            $table->string('ip_address', 45)->nullable()->comment('IP-адрес отправителя');
            $table->text('user_agent')->nullable()->comment('User-Agent браузера');
            $table->text('referrer')->nullable()->comment('Страница, с которой отправлена заявка');
            $table->string('landing_page', 500)->nullable()->comment('URL страницы, где оставлена заявка');
            $table->json('utm_params')->nullable()->comment('UTM-метки в JSON');

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes()->comment('Для архивации');

            // Индексы
            $table->index('status', 'leads_status_index');
            $table->index('priority', 'leads_priority_index');
            $table->index('assigned_to', 'leads_assigned_to_index');
            $table->index('request_type', 'leads_request_type_index');
            $table->index('source', 'leads_source_index');
            $table->index('created_at', 'leads_created_at_index');
            $table->index('phone', 'leads_phone_index');
            $table->index('email', 'leads_email_index');
            $table->index('next_call_at', 'leads_next_call_at_index');
            $table->index(['status', 'priority', 'created_at'], 'leads_composite_index');

            // Внешние ключи
            $table->foreign('assigned_to')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->foreign('processed_by')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('SET NULL');

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('SET NULL');

            $table->foreign('portfolio_id')
                ->references('id')
                ->on('portfolio')
                ->onDelete('SET NULL');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('SET NULL');

            $table->foreign('converted_to_client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('SET NULL');

            $table->comment('CRM: Заявки и лиды');
        });

        // Таблица для истории изменений статусов
        Schema::create('lead_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->string('old_status', 50)->nullable();
            $table->string('new_status', 50)->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('lead_id');
            $table->index('created_at');
        });

        // Таблица для задач по лидам
        Schema::create('lead_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('due_date')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['lead_id', 'status']);
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_tasks');
        Schema::dropIfExists('lead_status_history');
        Schema::dropIfExists('leads');
    }
};
