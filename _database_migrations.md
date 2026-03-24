# Содержимое папки: /database/migrations

Сгенерировано: 2026-02-25 11:18:00

## Структура файлов

```
database/migrations/0001_01_01_000000_create_users_table.php
database/migrations/0001_01_01_000001_create_cache_table.php
database/migrations/0001_01_01_000002_create_jobs_table.php
database/migrations/2015_04_12_000000_create_orchid_users_table.php
database/migrations/2015_10_19_214424_create_orchid_roles_table.php
database/migrations/2015_10_19_214425_create_orchid_role_users_table.php
database/migrations/2016_08_07_125128_create_orchid_attachmentstable_table.php
database/migrations/2017_09_17_125801_create_notifications_table.php
database/migrations/2026_02_16_061616_create_employees_table.php
database/migrations/2026_02_16_081528_create_blog_categories_table.php
database/migrations/2026_02_16_102412_create_settings_table.php
database/migrations/2026_02_16_102413_create_clients_table.php
database/migrations/2026_02_16_102413_create_equipment_table.php
database/migrations/2026_02_16_102414_create_blogs_table.php
database/migrations/2026_02_16_102415_create_advantages_table.php
database/migrations/2026_02_16_102415_create_sliders_table.php
database/migrations/2026_02_16_102416_create_pages_table.php
database/migrations/2026_02_16_102650_create_product_categories_table.php
database/migrations/2026_02_16_102650_create_products_table.php
database/migrations/2026_02_16_102705_create_services_table.php
database/migrations/2026_02_16_102720_create_portfolios_table.php
database/migrations/2026_02_16_102732_create_portfolio_services_table.php
database/migrations/2026_02_16_102733_create_portfolio_products_table.php
database/migrations/2026_02_16_102738_create_leads_table.php
database/migrations/2026_02_16_103050_create_s_e_o_s_table.php
database/migrations/2026_02_16_113450_create_f_a_q_s_table.php
database/migrations/2026_02_16_113450_create_site_statistics_table.php
database/migrations/2026_02_23_070930_create_tags_table.php
database/migrations/2026_02_23_071128_create_blog_tag_table.php
```

## Содержимое файлов

### database/migrations/0001_01_01_000000_create_users_table.php

```php
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

```

### database/migrations/0001_01_01_000001_create_cache_table.php

```php
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
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration')->index();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};

```

### database/migrations/0001_01_01_000002_create_jobs_table.php

```php
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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};

```

### database/migrations/2015_04_12_000000_create_orchid_users_table.php

```php
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
        Schema::table('users', function (Blueprint $table) {
            $table->jsonb('permissions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['permissions']);
        });
    }
};

```

### database/migrations/2015_10_19_214424_create_orchid_roles_table.php

```php
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
        Schema::create('roles', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->jsonb('permissions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

```

### database/migrations/2015_10_19_214425_create_orchid_role_users_table.php

```php
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
        Schema::create('role_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->primary(['user_id', 'role_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_users');
    }
};

```

### database/migrations/2016_08_07_125128_create_orchid_attachmentstable_table.php

```php
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
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('original_name');
            $table->string('mime');
            $table->string('extension')->nullable();
            $table->bigInteger('size')->default(0);
            $table->integer('sort')->default(0);
            $table->text('path');
            $table->text('description')->nullable();
            $table->text('alt')->nullable();
            $table->text('hash')->nullable();
            $table->string('disk')->default('public');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('group')->nullable();
            $table->timestamps();
        });

        Schema::create('attachmentable', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attachmentable_type');
            $table->unsignedInteger('attachmentable_id');
            $table->unsignedInteger('attachment_id');

            $table->index(['attachmentable_type', 'attachmentable_id']);

            $table->foreign('attachment_id')
                ->references('id')
                ->on('attachments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('attachmentable');
        Schema::drop('attachments');
    }
};

```

### database/migrations/2017_09_17_125801_create_notifications_table.php

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (! Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

```

### database/migrations/2026_02_16_061616_create_employees_table.php

```php
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

```

### database/migrations/2026_02_16_081528_create_blog_categories_table.php

```php
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
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};

```

### database/migrations/2026_02_16_102412_create_settings_table.php

```php
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

```

### database/migrations/2026_02_16_102413_create_clients_table.php

```php
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
        Schema::create('clients', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название компании-клиента');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->json('properties')->nullable();

            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Логотип клиента');
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
            $table->index('active', 'clients_active_index');
            $table->index('sort', 'clients_sort_index');

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
        Schema::dropIfExists('clients');
    }
};

```

### database/migrations/2026_02_16_102413_create_equipment_table.php

```php
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

```

### database/migrations/2026_02_16_102414_create_blogs_table.php

```php
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

```

### database/migrations/2026_02_16_102415_create_advantages_table.php

```php
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
        Schema::create('advantages', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название преимущества');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание преимущества');
            $table->longText('content')->nullable()->comment('Подробное описание преимущества');
            $table->json('properties')->nullable()->comment('Характеристики преимущества в формате JSON');

            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение преимущества');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение преимущества');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность преимущества');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации преимущества');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'advantages_active_index');
            $table->index('sort', 'advantages_sort_index');
            $table->index('published_at', 'advantages_published_at_index');
            $table->index(['active', 'sort'], 'advantages_active_sort_index');

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

            $table->comment('Преимущества компании, ее сильные стороны и конкурентные преимущества');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advantages');
    }
};

```

### database/migrations/2026_02_16_102415_create_sliders_table.php

```php
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
        Schema::create('sliders', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название слайдера');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание слайдера');
            $table->longText('content')->nullable()->comment('Подробное описание слайдера');
            $table->json('properties')->nullable()->comment('Характеристики слайдера в формате JSON');

            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение слайдера');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение слайдера');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность слайдера');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации слайдера');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'sliders_active_index');
            $table->index('sort', 'sliders_sort_index');
            $table->index('published_at', 'sliders_published_at_index');
            $table->index(['active', 'sort'], 'sliders_active_sort_index');

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

            $table->comment('слайдеры на главной странице');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};

```

### database/migrations/2026_02_16_102416_create_pages_table.php

```php
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

```

### database/migrations/2026_02_16_102650_create_product_categories_table.php

```php
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
        Schema::create('product_categories', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название категории');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание категории');
            $table->longText('content')->nullable()->comment('Подробное описание категории');
            $table->json('properties')->nullable()->comment('Характеристики категории в формате JSON');

            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение категории');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение категории');

            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность категории');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации категории');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'product_categories_active_index');
            $table->index('sort', 'product_categories_sort_index');
            $table->index('published_at', 'product_categories_published_at_index');
            $table->index(['active', 'sort'], 'product_categories_active_sort_index');

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

            $table->comment('категории продукции');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};

```

### database/migrations/2026_02_16_102650_create_products_table.php

```php
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
        Schema::create('products', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название продукта');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание продукта');
            $table->longText('content')->nullable()->comment('Подробное описание продукта');
            $table->json('properties')->nullable()->comment('Характеристики продукта в формате JSON');
            $table->unsignedBigInteger('category_id')->nullable();
            // Медиа
            $table->unsignedInteger('preview_id')->nullable()->comment('Изображение продукта');
            $table->unsignedInteger('detail_id')->nullable()->comment('Детальное изображение продукта');
            // Цена
            $table->decimal('price_from', 10, 2)->nullable()->comment('Цена от (в рублях)');
            // Метаданные
            $table->integer('sort')->default(0)->comment('Порядок сортировки');
            $table->boolean('active')->default(true)->comment('Активность продукта');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации продукта');

            // Аудит
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Timestamps и Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Индексы
            $table->index('active', 'products_active_index');
            $table->index('sort', 'products_sort_index');
            $table->index('published_at', 'products_published_at_index');
            $table->index(['active', 'sort'], 'products_active_sort_index');

            // Внешние ключи
            $table->foreign('preview_id')
                ->references('id')
                ->on('attachments')
                ->onDelete('SET NULL');

            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
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

            $table->comment('продукция компании, ее ассортимент');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

```

### database/migrations/2026_02_16_102705_create_services_table.php

```php
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

```

### database/migrations/2026_02_16_102720_create_portfolios_table.php

```php
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

```

### database/migrations/2026_02_16_102732_create_portfolio_services_table.php

```php
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
        Schema::create('portfolio_services', function (Blueprint $table) {
            // Ключи
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('service_id');

            // Дополнительные поля (если нужны)
            $table->integer('sort')->default(0)->comment('Порядок в списке');
            $table->timestamps();

            // Первичный составной ключ
            $table->primary(['portfolio_id', 'service_id'], 'portfolio_service_primary');

            // Индексы
            $table->index('portfolio_id', 'pws_portfolio_id_index');
            $table->index('service_id', 'pws_service_id_index');
            $table->index('sort', 'pws_sort_index');

            // Внешние ключи
            $table->foreign('portfolio_id')
                ->references('id')
                ->on('portfolio')
                ->onDelete('CASCADE');

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_services');
    }
};

```

### database/migrations/2026_02_16_102733_create_portfolio_products_table.php

```php
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
        Schema::create('portfolio_products', function (Blueprint $table) {
            // Ключи
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('product_id');

            // Дополнительные поля (если нужны)
            $table->integer('sort')->default(0)->comment('Порядок в списке');
            $table->timestamps();

            // Первичный составной ключ
            $table->primary(['portfolio_id', 'product_id'], 'portfolio_product_primary');

            // Индексы
            $table->index('portfolio_id', 'pwd_portfolio_id_index');
            $table->index('product_id', 'pwd_product_id_index');
            $table->index('sort', 'pwd_sort_index');

            // Внешние ключи
            $table->foreign('portfolio_id')
                ->references('id')
                ->on('portfolio')
                ->onDelete('CASCADE');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_products');
    }
};

```

### database/migrations/2026_02_16_102738_create_leads_table.php

```php
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

```

### database/migrations/2026_02_16_103050_create_s_e_o_s_table.php

```php
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
        Schema::create('seo', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Polymorphic relation
            $table->string('seoable_type', 255)->comment('Класс модели (Service, Product, etc.)');
            $table->unsignedBigInteger('seoable_id')->comment('ID записи');

            // SEO-поля
            $table->string('title', 255)->nullable()->comment('SEO Title (meta title)');
            $table->text('description')->nullable()->comment('SEO Description (meta description)');
            $table->string('keywords', 500)->nullable()->comment('SEO Keywords (устаревшее, но можно хранить)');

            // Open Graph (для соцсетей)
            $table->string('og_title', 255)->nullable()->comment('Open Graph Title');
            $table->text('og_description')->nullable()->comment('Open Graph Description');
            $table->unsignedInteger('og_image_id')->nullable()->comment('ID изображения для OG из attachments');

            // Дополнительно
            $table->string('canonical_url', 500)->nullable()->comment('Канонический URL (если отличается)');
            $table->string('robots', 100)->default('index, follow')->comment('Robots meta (index, noindex и т.д.)');

            // Timestamps
            $table->timestamps();

            // Уникальный индекс для polymorphic relation
            $table->unique(['seoable_type', 'seoable_id'], 'seo_seoable_type_seoable_id_unique');

            // Индексы
            $table->index('seoable_type', 'seo_seoable_type_index');

            // Внешние ключи
            $table->foreign('og_image_id')
                ->references('id')
                ->on('attachments')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_e_o_s');
    }
};

```

### database/migrations/2026_02_16_113450_create_f_a_q_s_table.php

```php
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
        Schema::create('f_a_q_s', function (Blueprint $table) {
            // Первичный ключ
            $table->id();

            // Контент
            $table->string('title', 255)->comment('Название вопроса');
            $table->string('slug', 255)->unique()->nullable()->comment('ЧПУ');
            $table->text('excerpt')->nullable()->comment('Краткое описание вопроса');
            $table->longText('content')->nullable()->comment('Подробное описание вопроса');
            $table->json('properties')->nullable()->comment('Характеристики вопроса в формате JSON');

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
            $table->index('active', 'f_a_q_s_active_index');
            $table->index('sort', 'f_a_q_s_sort_index');
            $table->index('published_at', 'f_a_q_s_published_at_index');
            $table->index(['active', 'sort'], 'f_a_q_s_active_sort_index');

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

            $table->comment('вопросы из раздела FAQ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_a_q_s');
    }
};

```

### database/migrations/2026_02_16_113450_create_site_statistics_table.php

```php
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

```

### database/migrations/2026_02_23_070930_create_tags_table.php

```php
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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};

```

### database/migrations/2026_02_23_071128_create_blog_tag_table.php

```php
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
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained('blogs')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Уникальность пары blog_id и tag_id
            $table->unique(['blog_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_tag');
    }
};

```

