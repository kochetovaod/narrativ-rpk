# Содержимое папки: database/seeders

Сгенерировано: 2026-03-02 15:47:52

## Структура файлов

```
database/seeders/AdminUserSeeder.php
database/seeders/AdvantageSeeder.php
database/seeders/AttachmentSeeder.php
database/seeders/BlogCategorySeeder.php
database/seeders/BlogSeeder.php
database/seeders/ClientSeeder.php
database/seeders/DatabaseSeeder.php
database/seeders/EmployeeSeeder.php
database/seeders/EquipmentSeeder.php
database/seeders/FAQSeeder.php
database/seeders/FaqCategorySeeder.php
database/seeders/LeadSeeder.php
database/seeders/MaterialSeeder.php
database/seeders/PageSeeder.php
database/seeders/PortfolioProductSeeder.php
database/seeders/PortfolioSeeder.php
database/seeders/PortfolioServiceSeeder.php
database/seeders/ProductCategoryFilterSeeder.php
database/seeders/ProductCategoryFilterValueSeeder.php
database/seeders/ProductCategorySeeder.php
database/seeders/ProductSeeder.php
database/seeders/RolesAndPermissionsSeeder.php
database/seeders/SEOSeeder.php
database/seeders/ServiceSeeder.php
database/seeders/SettingSeeder.php
database/seeders/SiteStatisticSeeder.php
database/seeders/SliderSeeder.php
database/seeders/TagSeeder.php
database/seeders/TechnologySeeder.php
```

## Содержимое файлов

### database/seeders/AdminUserSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Models\Role;
use Orchid\Support\Facades\Dashboard;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@narrative.com'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('1810'),
                'permissions' => Dashboard::getAllowAllPermission(),
            ]
        );
        $manager = User::updateOrCreate(
            ['email' => 'manager@narrative.com'],
            [
                'name' => 'Менеджер',
                'password' => Hash::make('1810'),
                'permissions' => Dashboard::getAllowAllPermission(),
            ]
        );

        $adminRole = Role::where('slug', 'admin')->first();
        $managerRole = Role::where('slug', 'manager')->first();
        $admin->roles()->syncWithoutDetaching($adminRole);
        $manager->roles()->syncWithoutDetaching($managerRole);
    }
}

```

### database/seeders/AdvantageSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Advantage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AdvantageSeeder extends Seeder
{
    protected array $items = [
        [
            'title' => 'Полный производственный цикл',
            'icon' => 'advantage_cicle',
            'text' => 'От разработки дизайна и согласования до изготовления и монтажа — всё под одной крышей. Никаких субподрядчиков, полная ответственность.',
        ],
        [
            'title' => 'Точные сроки',
            'icon' => 'advantage_clock',
            'text' => 'Мы работаем по договору с фиксированными датами. Простые проекты — от 3 дней, сложные конструкции — по согласованному графику.',
        ],
        [
            'title' => 'Высокое качество материалов',
            'icon' => 'advantage_quality',
            'text' => 'Работаем только с проверенными поставщиками — акрил Altuglas, плёнки Oracal и Avery, светодиоды Samsung и Epistar.',
        ],
        [
            'title' => 'Официальная работа',
            'icon' => 'advantage_work',
            'text' => 'Работаем с юридическими лицами и ИП по договору, закрываем сделку актами, предоставляем все необходимые документы.',
        ],
        [
            'title' => 'Гарантия на изделия',
            'icon' => 'advantage_guaranty',
            'text' => '12 месяцев на все конструкции собственного производства. При необходимости выезжаем на гарантийное обслуживание.',
        ],
        [
            'title' => 'Бесплатный выезд на замер',
            'icon' => 'advantage_freemetring',
            'text' => 'Абсолютно бесплатно выезжаем на замер и консультацию по вашему проекту. Оставьте заявку и убедитесь в качестве нашего сервиса.',
        ],
    ];

    public function run(): void
    {
        Advantage::truncate();

        foreach ($this->items as $index => $item) {
            Advantage::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['icon'],
                'content' => $item['text'],
                'sort' => $index + 1,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $this->command->info("Создано преимущество: {$item['title']}");
        }
    }
}

```

### database/seeders/AttachmentSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        // Сохраняем основные изображения
        $this->saveImagesFromFolder('main', 'main', 'Логотипы и иконки');
        // Сохраняем изображения для блога из папки seed/blog
        $this->saveImagesFromFolder('blog', 'blog', 'Изображение блога');
        // Сохраняем изображения для авторов из папки seed/employees
        $this->saveImagesFromFolder('employees', 'employees', 'Изображение сотрудника');
        // Сохраняем изображения для клиентов из папки seed/clients
        $this->saveImagesFromFolder('clients', 'clients', 'Изображение клиента');
        // Сохраняем изображения для оборудования из папки seed/equipment
        $this->saveImagesFromFolder('equipment', 'equipment', 'Изображение оборудования');
        // Сохраняем изображения для слайдера из папки seed/slider
        $this->saveImagesFromFolder('slider', 'slider', 'Изображение слайдера');
        // Сохраняем изображения для портфолио из папки seed/portfolio
        $this->saveImagesFromFolder('portfolio', 'portfolio', 'Изображение работы портфолио');
        // Сохраняем изображения для страниц из папки seed/pages
        $this->saveImagesFromFolder('pages', 'pages', 'Изображение для страниц');
        // Сохраняем изображения для услуг из папки seed/pages
        $this->saveImagesFromFolder('services', 'services', 'Изображение для услуг');
        $this->saveImagesFromFolder('product_categories', 'product_categories', 'Изображение для услуг');

    }

    private function saveImagesFromFolder(string $folder, string $group, string $descriptionPrefix): void
    {
        $path = storage_path('app/public/seed/'.$folder);

        if (! is_dir($path)) {
            $this->command->warn("Папка seed/{$folder} не найдена");

            return;
        }

        // Получаем все файлы из папки
        $files = scandir($path);

        foreach ($files as $file) {
            // Пропускаем системные директории
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $path.'/'.$file;

            // Проверяем, что это файл, а не директория
            if (! is_file($filePath)) {
                continue;
            }

            // Проверяем, что файл является изображением
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico', 'webmanifest'];

            if (! in_array($extension, $allowedExtensions)) {
                $this->command->warn("Файл {$file} не является изображением, пропускаем");

                continue;
            }

            // Генерируем имя без расширения для alt и description
            $nameWithoutExt = pathinfo($file, PATHINFO_FILENAME);

            // Удаляем старую запись, если есть
            Attachment::where('original_name', $file)->delete();

            $uploadedFile = new UploadedFile(
                $filePath,
                $file,
                null,
                null,
                true
            );

            $attachment = (new File($uploadedFile))
                ->path('attachments/'.$group)
                ->load();

            // Обновляем дополнительные поля
            $attachment->update([
                'description' => "{$descriptionPrefix}: {$nameWithoutExt}",
                'alt' => $nameWithoutExt,
                'group' => $group,
                'user_id' => 1,
            ]);
        }
        $this->command->info("Созданы attachments для {$group}");
    }
}

```

### database/seeders/BlogCategorySeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Выбор и проектирование',
                'slug' => Str::slug('Выбор и проектирование'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Материалы и технологии',
                'slug' => Str::slug('Материалы и технологии'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Правовые и сезонные аспекты',
                'slug' => Str::slug('Правовые и сезонные аспекты'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Бизнесу под ключ',
                'slug' => Str::slug('Бизнесу под ключ'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('blog_categories')->insert($categories);

        $this->command->info('Blog categories seeded successfully!');
    }
}

```

### database/seeders/BlogSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Employee;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class BlogSeeder extends Seeder
{
    protected array $articles = [
        [
            'filename' => '01-goroskop-vyveski.md',
            'title' => 'Какая вывеска подойдет вашему бизнесу: выбираем идеальный дизайн по знаку зодиака',
            'excerpt' => 'Хотите, чтобы вывеска приносила удачу? Узнайте, какой дизайн наружной рекламы в Самаре подойдет вашему бизнесу по знаку зодиака — от ярких решений для Овна до элегантной классики для Козерога.',
            'preview_image' => '1_preview.png',
            'detail_image' => '1_banner.webp',
            'author_key' => 'Борисов Д.А.',
            'sort' => 1,
            'published_at' => '2026-01-15',
            'category' => 'Выбор и проектирование',
            'tags' => ['Дизайн и стиль', 'Типы подсветки', 'Объемные буквы'],
        ],
        [
            'filename' => '02-akril-komposit-metall.md',
            'title' => 'Акрил, композит или металл: из чего делают современные вывески',
            'excerpt' => 'Акрил, композит или металл: гид по материалам для наружной рекламы в Самаре — разбираем плюсы, минусы и особенности современных вывесок от экспертов компании «Нарратив».',
            'preview_image' => '2_preview.webp',
            'detail_image' => '2_banner.webp',
            'author_key' => 'Соколов А.В.',
            'sort' => 2,
            'published_at' => '2026-01-20',
            'category' => 'Материалы и технологии',
            'tags' => ['Материалы', 'Световые короба', 'Объемные буквы'],
        ],
        [
            'filename' => '03-10-oshibok-vyveski.md',
            'title' => '10 ошибок при заказе вывески, которые превратят ваш фасад в «колхоз»',
            'excerpt' => 'Пластиковый короб на сталинском ампире и текст, который никто не прочтет: разбираем 10 главных ошибок при заказе вывесок в Самаре, которые превратят ваш фасад в «колхоз».',
            'preview_image' => '3_preview.webp',
            'detail_image' => '3_banner.webp',
            'author_key' => 'Соколов А.В.',
            'sort' => 3,
            'published_at' => '2026-01-25',
            'category' => 'Выбор и проектирование',
            'tags' => ['Дизайн и стиль', 'Монтаж и сервис', 'Бюджетирование'],
        ],
        [
            'filename' => '04-soglasovanie-vyveski-2026.md',
            'title' => 'Пошаговый гайд по согласованию вывески в 2026 году в Самаре',
            'excerpt' => 'Штрафы до 75 000 рублей, русский язык в приоритете и дизайн-код: пошаговый гайд по согласованию вывесок в Самаре в 2026 году от экспертов компании «Нарратив».',
            'preview_image' => '4_preview.webp',
            'detail_image' => '4_banner.webp',
            'author_key' => 'Борисов Д.А.',
            'sort' => 4,
            'published_at' => '2026-02-01',
            'category' => 'Правовые и сезонные аспекты',
            'tags' => ['Согласование', 'Монтаж и сервис'],
        ],
        [
            'filename' => '05-topolinyj-puh.md',
            'title' => 'Тополиный пух, жара, июль: готовим бизнес к лету',
            'excerpt' => 'Тополиный пух, жара и выгоревшие буквы: как подготовить наружную рекламу в Самаре к лету — экспертные советы по выбору материалов и сезонному обслуживанию от компании «Нарратив».',
            'preview_image' => '5_preview.webp',
            'detail_image' => '5_banner.webp',
            'author_key' => 'Соколов А.В.',
            'sort' => 5,
            'published_at' => '2026-02-10',
            'category' => 'Правовые и сезонные аспекты',
            'tags' => ['Сезонность', 'Монтаж и сервис', 'Материалы'],
        ],
        [
            'filename' => '06-test-vyveska.md',
            'title' => 'Тест: какая вывеска нужна вашему бизнесу?',
            'excerpt' => 'Не знаете, какая вывеска подойдет вашему бизнесу? Пройдите тест от компании «Нарратив» и получите готовую рекомендацию — от неона для уютной кофейни до строгих объемных букв для банка в Самаре.',
            'preview_image' => '6_preview.webp',
            'detail_image' => '6_banner.png',
            'author_key' => 'Борисов Д.А.',
            'sort' => 6,
            'published_at' => '2026-02-15',
            'category' => 'Выбор и проектирование',
            'tags' => ['Дизайн и стиль', 'Типы подсветки', 'Бюджетирование'],
        ],
        [
            'filename' => '07-trendy-2026.md',
            'title' => 'Тренды 2026 года в наружной рекламе: минимализм, неон или «неон наоборот»?',
            'excerpt' => 'От «парящего» минимализма до гибкого неона: обзор главных трендов наружной рекламы 2026 года в Самаре — как выбрать стиль, который выделит ваш бизнес.',
            'preview_image' => '7_preview.png',
            'detail_image' => '7_banner.jpeg',
            'author_key' => 'Ларина М.С.',
            'sort' => 7,
            'published_at' => '2026-02-20',
            'category' => 'Бизнесу под ключ',
            'tags' => ['Дизайн и стиль', 'Типы подсветки'],
        ],
        [
            'filename' => '08-byudzhet-vyveska.md',
            'title' => 'Бюджет на вывеску в Самаре 2026: на чем экономить нельзя, а где можно срезать углы без потери качества',
            'excerpt' => 'Как не переплатить за вывеску в Самаре? Рассказываем, на чем можно сэкономить без потери качества, а где экономия приведет к штрафам и ремонту — разбор цен 2026 года от компании «Нарратив».',
            'preview_image' => '8_preview.jpeg',
            'detail_image' => '8_banner.jpeg',
            'author_key' => 'Борисов Д.А.',
            'sort' => 8,
            'published_at' => '2026-02-25',
            'category' => 'Бизнесу под ключ',
            'tags' => ['Бюджетирование', 'Материалы', 'Монтаж и сервис'],
        ],
        [
            'filename' => '09-dizajn-vyveski.md',
            'title' => 'Дизайн вывески: 5 вопросов, которые нужно задать дизайнеру в Самаре, чтобы не получить «колхоз» на фасаде',
            'excerpt' => 'Как не получить «колхоз» на фасаде: 5 вопросов дизайнеру вывесок в Самаре — про шрифты, подсветку, архитектуру и технологичность изготовления от экспертов компании «Нарратив».',
            'preview_image' => '9_preview.jpeg',
            'detail_image' => '9_banner.jpeg',
            'author_key' => 'Ларина М.С.',
            'sort' => 9,
            'published_at' => '2026-02-01',
            'category' => 'Выбор и проектирование',
            'tags' => ['Дизайн и стиль', 'Типы подсветки', 'Объемные буквы'],
        ],
        [
            'filename' => '10-interernaya-reklama.md',
            'title' => 'Интерьерная реклама в Самаре: как заставить клиента покупать с помощью навигации, света и пластика',
            'excerpt' => 'От навигации до POSM-материалов: как с помощью интерьерной рекламы в Самаре заставить клиента покупать — световые панели, таблички и УФ-печать от «Нарратив».',
            'preview_image' => '10_preview.jpeg',
            'detail_image' => '10_banner.jpeg',
            'author_key' => 'Ларина М.С.',
            'sort' => 10,
            'published_at' => '2026-02-05',
            'category' => 'Бизнесу под ключ',
            'tags' => ['Интерьерная реклама', 'Световые короба', 'Дизайн и стиль'],
        ],
        [
            'filename' => '11-obemnye-bukvy.md',
            'title' => 'Объемные буквы для фасада: как выбрать идеальный вариант для бизнеса в Самаре',
            'excerpt' => 'Ищете идеальные объемные буквы для фасада в Самаре? Подробный гид по типам конструкций — от классики до премиума: выбираем подсветку, материалы и стиль для вашего бизнеса.',
            'preview_image' => '11_preview.png',
            'detail_image' => '11_banner.jpeg',
            'author_key' => 'Соколов А.В.',
            'sort' => 11,
            'published_at' => '2026-02-10',
            'category' => 'Материалы и технологии',
            'tags' => ['Объемные буквы', 'Типы подсветки', 'Материалы'],
        ],
    ];

    public function run(): void
    {
        $this->command->info('🚀 Начинаем заполнение блога...');
        $this->command->newLine();

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($this->articles as $articleData) {
            // Поиск файла Markdown
            $markdownPath = storage_path('app/public/seed/markdown/'.$articleData['filename']);

            if (! file_exists($markdownPath)) {
                $this->command->warn("⚠️ Markdown файл {$articleData['filename']} не найден по пути: {$markdownPath}");
                $skippedCount++;

                continue;
            }

            // Чтение содержимого Markdown
            $content = file_get_contents($markdownPath);

            // Поиск категории
            $category = $this->findCategory($articleData['category']);

            // Поиск превью-изображения
            $previewAttachment = $this->findAttachment($articleData['preview_image'], 'preview');

            // Поиск детального изображения (баннера)
            $detailAttachment = $this->findAttachment($articleData['detail_image'], 'detail');

            // Поиск автора
            $author = $this->findAuthor($articleData['author_key']);

            // Генерация случайных значений
            $views = rand(500, 5000);      // Случайные просмотры от 500 до 5000
            $likes = rand(20, 200);         // Случайные лайки от 20 до 200
            $timeRead = rand(3, 10);         // Случайное время чтения от 3 до 10 минут

            // Корректируем лайки, чтобы они не превышали просмотры
            $likes = min($likes, round($views * 0.3)); // Лайки не более 30% от просмотров

            // Создание записи в блоге
            $blog = Blog::create([
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']),
                'excerpt' => $articleData['excerpt'],
                'content' => $content,
                'views' => $views,
                'likes' => $likes,
                'time_read' => $timeRead,
                'category_id' => $category?->id,
                'preview_id' => $previewAttachment?->id,
                'detail_id' => $detailAttachment?->id,
                'author_id' => $author?->id,
                'sort' => $articleData['sort'],
                'active' => true,
                'published_at' => Carbon::parse($articleData['published_at']),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            // Привязка тегов
            if (! empty($articleData['tags'])) {
                $tagIds = $this->getTagIds($articleData['tags']);
                $blog->tags()->attach($tagIds);
            }

            $createdCount++;

            // Красивый вывод информации о созданной статье
            $authorName = $author ? $author->title : 'без автора';
            $categoryName = $category ? $category->title : 'без категории';
            $previewStatus = $previewAttachment ? '✓' : '✗';
            $detailStatus = $detailAttachment ? '✓' : '✗';
            $tagsList = ! empty($articleData['tags']) ? implode(', ', $articleData['tags']) : 'нет тегов';

            $this->command->info("✅ [{$articleData['sort']}] {$articleData['title']}");
            $this->command->line("   └─ Автор: {$authorName} | Категория: {$categoryName}");
            $this->command->line("   └─ Превью: {$previewStatus} | Баннер: {$detailStatus}");
            $this->command->line("   └─ Теги: {$tagsList}");
            $this->command->line("   └─ Статистика: {$views} просмотров, {$likes} 👍, {$timeRead} мин.");
            $this->command->newLine();
        }

        $this->command->info('📊 Итоги:');
        $this->command->table(
            ['Показатель', 'Значение'],
            [
                ['✅ Создано статей', $createdCount],
                ['⚠️ Пропущено (нет файлов)', $skippedCount],
                ['📅 Дата последней публикации', end($this->articles)['published_at']],
            ]
        );

        $this->command->newLine();
        $this->command->info('🎉 BlogSeeder завершен успешно!');
    }

    /**
     * Поиск категории по названию
     */
    private function findCategory(string $categoryTitle): ?BlogCategory
    {
        $category = BlogCategory::where('title', $categoryTitle)->first();

        if (! $category) {
            $this->command->warn("   Категория '{$categoryTitle}' не найдена в базе");
        }

        return $category;
    }

    /**
     * Получение ID тегов по их названиям
     */
    private function getTagIds(array $tagTitles): array
    {
        $tagIds = [];

        foreach ($tagTitles as $tagTitle) {
            $tag = Tag::where('title', $tagTitle)->first();

            if ($tag) {
                $tagIds[] = $tag->id;
            } else {
                $this->command->warn("   Тег '{$tagTitle}' не найден в базе");
            }
        }

        return $tagIds;
    }

    /**
     * Поиск attachment по имени файла
     */
    private function findAttachment(string $filename, string $type): ?Attachment
    {
        // Сначала ищем по точному совпадению original_name
        $attachment = Attachment::where('original_name', $filename)->first();

        if ($attachment) {
            return $attachment;
        }

        // Если не нашли, ищем по части имени (без расширения)
        $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $attachment = Attachment::where('original_name', 'like', '%'.$nameWithoutExt.'%')->first();

        if ($attachment) {
            return $attachment;
        }

        // Если всё равно не нашли, ищем по альтернативным именам (на случай разных расширений)
        $alternatives = [
            $nameWithoutExt.'.jpg',
            $nameWithoutExt.'.jpeg',
            $nameWithoutExt.'.png',
            $nameWithoutExt.'.webp',
            $nameWithoutExt.'.gif',
            $nameWithoutExt.'.bmp',
        ];

        foreach ($alternatives as $alt) {
            $attachment = Attachment::where('original_name', $alt)->first();
            if ($attachment) {
                $this->command->line("   Найден альтернативный файл для {$filename}: {$alt}");

                return $attachment;
            }
        }

        $this->command->warn("   {$type} изображение {$filename} не найдено в базе attachments");

        return null;
    }

    /**
     * Поиск автора по имени или инициалам
     */
    private function findAuthor(string $authorKey): ?Employee
    {
        // Массив соответствия для надежности
        $authorMap = [
            'Борисов Д.А.' => 'Борисов Д.А.',
            'Соколов А.В.' => 'Соколов А.В.',
            'Ларина М.С.' => 'Ларина М.С.',
        ];

        $searchName = $authorMap[$authorKey] ?? $authorKey;

        // Сначала ищем по точному совпадению имени
        $employee = Employee::where('title', 'like', '%'.$searchName.'%')->first();

        if ($employee) {
            return $employee;
        }

        // Разбираем инициалы (например, "Борисов Д.А.")
        if (preg_match('/([А-Яа-я]+)\s+([А-Я])\.?([А-Я])\.?/', $authorKey, $matches)) {
            $lastName = $matches[1];
            $firstNameInitial = $matches[2];

            // Ищем по фамилии
            $employee = Employee::where('title', 'like', $lastName.'%')->first();

            if ($employee) {
                return $employee;
            }
        }

        // Если ничего не нашли, пробуем поискать просто по фамилии
        $lastNameOnly = strtok($authorKey, ' ');
        $employee = Employee::where('title', 'like', '%'.$lastNameOnly.'%')->first();

        if ($employee) {
            $this->command->line("   Найден автор по фамилии {$lastNameOnly}: {$employee->title}");

            return $employee;
        }

        $this->command->warn("   Автор {$authorKey} не найден в таблице employees");

        return null;
    }
}

```

### database/seeders/ClientSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class ClientSeeder extends Seeder
{
    protected array $items = [

        [
            'title' => 'Самара-Сити',
            'image' => 'Современныи_логотип_для_крупнои_се_0.webp',
            'excerpt' => 'Крупнейший гипермаркет в Самаре, предлагающий широкий ассортимент продуктов и товаров для дома. Постоянно развивает сеть и модернизирует фасады своих магазинов.',
        ],

        [
            'title' => 'Стиль+',
            'image' => 'Elegant_fashion_boutique_Магазин_о_1.webp',
            'excerpt' => 'Бутик модной одежды для всей семьи с акцентом на актуальные тренды и качественные материалы. Ценит стильные решения в оформлении витрин и торговых залов.',
        ],

        [
            'title' => 'Мир детства',
            'image' => 'Playful_kids_toy_store_logo_brigh_0.webp',
            'excerpt' => 'Магазин игрушек и детских товаров, где каждый ребёнок найдёт себе развлечение. Создаёт яркое и запоминающееся пространство для детей и родителей.',
        ],

        [
            'title' => 'Утро',
            'image' => 'Cozy_cafe_logo_soft_gradient_of_o_0.webp',
            'excerpt' => 'Уютное кафе в центре города с домашней выпечкой, ароматным кофе и атмосферой, располагающей к неспешным беседам и приятному началу дня.',
        ],

        [
            'title' => 'Креатив',
            'image' => 'Trendy_bar_logo_edgy_style_glowi_0.webp',
            'excerpt' => 'Современный бар с авторскими коктейлями, неоновым освещением и динамичной атмосферой. Популярное место для встреч с друзьями и вечеринок.',
        ],

        [
            'title' => 'Русская трапеза',
            'image' => 'Russian_traditional_restaurant_log_1.webp',
            'excerpt' => 'Ресторан традиционной русской кухни, где гостей встречают гостеприимством, сытными блюдами и аутентичным интерьером в народном стиле.',
        ],

        [
            'title' => 'АвтоЛюкс',
            'image' => 'Luxury_car_dealership_Автосалон__А_0.webp',
            'excerpt' => 'Премиальный автосалон, представляющий автомобили мировых брендов. Особое внимание уделяет статусному оформлению шоу-рума и фасада.',
        ],

        [
            'title' => 'ТехноСервис',
            'image' => 'Auto_repair_shop_Автомастерская_«Т_0.webp',
            'excerpt' => 'Профессиональная автомастерская с современным оборудованием для диагностики и ремонта автомобилей любых марок. Гарантия качества и оперативность.',
        ],

        [
            'title' => 'Здоровье семьи',
            'image' => 'Medical_clinic_Медицинскии_центр___0.webp',
            'excerpt' => 'Многопрофильный медицинский центр для всей семьи. Комплексный подход к здоровью, опытные специалисты и современное диагностическое оборудование.',
        ],

        [
            'title' => 'Белоснежка',
            'image' => 'Dental_clinic_Стоматология__Белосн_0.webp',
            'excerpt' => 'Современная стоматологическая клиника с акцентом на безболезненное лечение и эстетику улыбки. Индивидуальный подход к каждому пациенту.',
        ],

        [
            'title' => 'Волга-Кредит',
            'image' => 'Financial_bank_Банк__Волга-Кредит__1.webp',
            'excerpt' => 'Региональный банк с широкой сетью отделений в Самаре. Предлагает выгодные кредитные продукты, вклады и расчётно-кассовое обслуживание бизнеса.',
        ],

        [
            'title' => 'Капитал-Полис',
            'image' => 'Insurance_company_Страховая_компан_2.webp',
            'excerpt' => 'Надёжная страховая компания, предлагающая полисы для автомобилей, недвижимости и здоровья. Быстрые выплаты и прозрачные условия страхования.',
        ],

        [
            'title' => 'Атлетик',
            'image' => 'Fitness_center_Фитнес-клуб__Атлети_0.webp',
            'excerpt' => 'Современный фитнес-клуб с просторным тренажёрным залом, групповыми программами и зоной единоборств. Мотивирующая атмосфера для достижения целей.',
        ],

        [
            'title' => 'Красота ногтей',
            'image' => 'Nail_salon_Студия_маникюра__Красот_1.webp',
            'excerpt' => 'Профессиональная студия маникюра и педикюра с широкой палитрой материалов и дизайнов. Комфортная обстановка и внимательные мастера.',
        ],

        [
            'title' => 'ДомСтрой',
            'image' => 'Construction_company_Строительная__1.webp',
            'excerpt' => 'Надёжная строительная компания, специализирующаяся на возведении жилых комплексов и коммерческих объектов. Качество и соблюдение сроков.',
        ],

        [
            'title' => 'МастерОК',
            'image' => 'Handyman_service_Ремонтная_мастерс_0.webp',
            'excerpt' => 'Служба быстрого ремонта и обслуживания. Мелкий и крупный ремонт, сантехника, электрика — решаем любые бытовые проблемы оперативно и качественно.',
        ],

        [
            'title' => 'Комфорт',
            'image' => 'Hotel_Отель__Комфорт__logo_elegan_1.webp',
            'excerpt' => 'Уютный отель в центре Самары с современными номерами, рестораном и конференц-залом. Идеальное место для деловых поездок и семейного отдыха.',
        ],

        [
            'title' => 'Путешествие мечты',
            'image' => 'Travel_agency_Турфирма__Путешестви_0.webp',
            'excerpt' => 'Туристическое агентство с индивидуальным подходом к организации поездок. Помогаем воплотить мечты в реальность — от экскурсий до экзотических туров.',
        ],

        [
            'title' => 'Солнышко',
            'image' => 'Kindergarten_Частныи_детскии_сад___0.webp',
            'excerpt' => 'Частный детский сад с развивающими программами, заботливыми воспитателями и комфортными условиями для гармоничного развития детей.',
        ],

        [
            'title' => 'English Time',
            'image' => 'Language_school_Школа_англииского__1.webp',
            'excerpt' => 'Школа английского языка для детей и взрослых. Коммуникативная методика, разговорная практика и подготовка к международным экзаменам.',
        ],

    ];

    public function run(): void
    {

        foreach ($this->items as $index => $item) {

            $attachment = Attachment::where('original_name', $item['image'])->first();

            if (! $attachment) {
                $this->command->warn("Attachment {$item['image']} не найден");

                continue;
            }

            Client::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['excerpt'],
                'preview_id' => $attachment->id,
                'detail_id' => $attachment->id,
                'sort' => $index + 1,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $this->command->info("Создан клиент: {$item['title']}");
        }
    }
}

```

### database/seeders/DatabaseSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            // Сначала создаем attachments
            AttachmentSeeder::class,

            // Затем создаем настройки с ссылками на attachments
            SettingSeeder::class,

            // Другие сидеры...

            ClientSeeder::class,
            EquipmentSeeder::class,
            AdvantageSeeder::class,
            FaqCategorySeeder::class,
            FAQSeeder::class,
            ProductCategorySeeder::class,

            ProductCategoryFilterSeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,

            PortfolioSeeder::class,
            SliderSeeder::class,
            EmployeeSeeder::class,
            LeadSeeder::class,
            BlogCategorySeeder::class,
            TagSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,
            SEOSeeder::class,
            MaterialSeeder::class,
            TechnologySeeder::class,
        ]);
    }
}

```

### database/seeders/EmployeeSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Orchid\Attachment\Models\Attachment;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Массив с данными сотрудников
        $employees = [
            [
                'name' => 'Андрей Викторович Соколов',
                'position' => 'Руководитель производства',
                'bio' => 'Технарь с опытом. Пишет про материалы, ошибки монтажа, производственные нюансы — то, что знает изнутри.',
                'image' => '1.png', // Предполагаемое имя файла
            ],
            [
                'name' => 'Марина Сергеевна Ларина',
                'position' => 'Ведущий дизайнер',
                'bio' => 'Отвечает за визуальную часть: дизайн, тренды, интерьерную рекламу, эстетику вывесок.',
                'image' => '2.png', // Предполагаемое имя файла
            ],
            [
                'name' => 'Дмитрий Алексеевич Борисов',
                'position' => 'Менеджер по работе с клиентами',
                'bio' => 'Ближе всего к клиенту — пишет про согласование, бюджет, практические кейсы и лёгкий контент (гороскоп, тест).',
                'image' => '3.png', // Предполагаемое имя файла
            ],
        ];

        foreach ($employees as $employeeData) {
            // Ищем attachment по имени файла
            $attachment = Attachment::where('original_name', $employeeData['image'])->first();

            // Если не нашли по точному имени, пробуем найти по частичному совпадению
            if (! $attachment) {
                $attachment = Attachment::where('original_name', 'like', '%'.pathinfo($employeeData['image'], PATHINFO_FILENAME).'%')->first();
            }

            $employee = new Employee;
            // Создаем сотрудника
            $employee->forceFill([
                'title' => $employeeData['name'],
                'excerpt' => $employeeData['position'],
                'content' => $employeeData['bio'],
                'preview_id' => $attachment ? $attachment->id : null,
                'active' => true,
                'published_at' => now(),
                'sort' => 0,
            ]);

            $employee->save();

            $this->command->info("Создан сотрудник: {$employeeData['name']}".($attachment ? '' : ' (без аватарки)'));
        }
    }

    /**
     * Получить инициалы из ФИО
     */
    private function getInitials(string $fullName): string
    {
        $parts = explode(' ', $fullName);
        $initials = '';

        foreach ($parts as $part) {
            if (! empty($part)) {
                $initials .= mb_substr($part, 0, 1, 'UTF-8');
            }
        }

        return $initials;
    }
}

```

### database/seeders/EquipmentSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Enums\EquipmentCategory;
use App\Models\Equipment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class EquipmentSeeder extends Seeder
{
    protected array $items = [

        // 1. SUDA (Фрезер) - sort 1
        [
            'title' => 'Фрезерно-гравировальный станок Suda VG2030',
            'image' => 'SudaVG2030.webp',
            'excerpt' => 'Профессиональный фрезерный центр с рабочим полем 3000×2000 мм для крупногабаритных конструкций и точной обработки сложных элементов.',
            'content' => 'Мощный фрезерный станок с огромным рабочим полем 3000х2000 мм предназначен для производства крупногабаритных рекламных конструкций. Позволяет изготавливать цельные фасады, панели-кронштейны и основы для световых коробов без стыков, что гарантирует идеальную геометрию и прочность изделий. Стабильно и точно обрабатывает пластик, композитные материалы (АКП), дерево и мягкие металлы.',
            'category' => EquipmentCategory::MILLING,
            'manufacturer' => 'Suda CNC (Китай)',
            'year' => 2022,
            'sort' => 1,
            'properties' => [
                ['label' => 'Поле обработки', 'value' => '3000 × 2000 мм'],
                ['label' => 'Мощность шпинделя', 'value' => '3 кВт'],
                ['label' => 'Точность', 'value' => '±0,1 мм'],
                ['label' => 'Материалы', 'value' => 'ПВХ, акрил, МДФ, дерево'],
            ],
        ],

        // 2. WoodTec (Фрезер) - sort 2
        [
            'title' => 'Фрезерно-гравировальный станок с ЧПУ WoodTec CH-1325',
            'image' => 'WoodTec1325.webp',
            'excerpt' => 'Мощный 3-осевой фрезерный центр с рабочим полем 1300×2500 мм для изготовления объемных букв, фасадов и крупногабаритных элементов...',
            'content' => 'Универсальный фрезерный центр для высокоточной обработки листовых материалов. Идеально подходит для раскроя заготовок под объемные буквы, фасады вывесок и сложной художественной резьбы. Благодаря жесткой станине, станок исключает вибрации и гарантирует идеальную геометрию даже при интенсивных нагрузках, что критически важно для производства качественной наружной рекламы.',
            'category' => EquipmentCategory::MILLING,
            'manufacturer' => 'WoodTec (Китай)',
            'year' => 2023,
            'sort' => 2,
            'properties' => [
                ['label' => 'Поле обработки', 'value' => '1300 × 2500 мм'],
                ['label' => 'Мощность шпинделя', 'value' => '5,5 кВт'],
                ['label' => 'Скорость вращения', 'value' => 'до 18 000 об/мин'],
                ['label' => 'Материалы', 'value' => 'Древесина, МДФ, ДСП, акрил, ПВХ, композиты, цветные металлы'],
            ],
        ],

        // 3. НТ-1325A (Фрезер) - sort 3
        [
            'title' => 'Фрезерно-гравировальный станок с ЧПУ НТ-1325A',
            'image' => 'NT-1325A.webp',
            'excerpt' => 'Настольный фрезерный центр с рабочим полем 2500×1250 мм для 2D и 3D обработки пластиков, МДФ, фанеры и композитов.',
            'content' => 'Экономичное и надежное решение для рекламного производства. Станок предназначен для раскроя листовых материалов, фрезеровки объемных букв и изготовления элементов декора. Обеспечивает стабильность и высокую точность обработки пластиков, МДФ, фанеры и композитных материалов, позволяя получать чистые заготовки без сколов для последующей сборки.',            'category' => EquipmentCategory::MILLING,
            'manufacturer' => 'НТ (Китай)',
            'year' => 2022,
            'sort' => 3,
            'properties' => [
                ['label' => 'Поле обработки', 'value' => '2500 × 1250 мм'],
                ['label' => 'Мощность шпинделя', 'value' => '3,2 кВт'],
                ['label' => 'Точность', 'value' => '±0,05 мм'],
                ['label' => 'Материалы', 'value' => 'ПВХ, акрил, МДФ, фанера, пластики'],
            ],
        ],

        // 4. Лазер 1390 - sort 4
        [
            'title' => 'CO₂-лазерный станок с ЧПУ 1390 (1300×900 мм)',
            'image' => 'laser-1390.webp',
            'excerpt' => 'Универсальный лазерный станок для резки и гравировки листовых материалов. Рабочее поле 1300×900 мм...',
            'content' => 'Базовая «рабочая лошадка» рекламного производства. Лазерный станок предназначен для высокоточной резки и гравировки акрила (оргстекла), фанеры, МДФ и пластика. Позволяет создавать объемные буквы, элементы декора и сувенирную продукцию с идеально ровными краями и мельчайшими деталями. Оснащен системой охлаждения и вытяжкой для комфортной и безопасной работы.',
            'category' => EquipmentCategory::LASER,
            'manufacturer' => 'Rayden / Cormak / HN',
            'year' => 2023,
            'sort' => 4,
            'properties' => [
                ['label' => 'Поле обработки', 'value' => '1300 × 900 мм'],
                ['label' => 'Мощность лазера', 'value' => '100–150 Вт (CO₂)'],
                ['label' => 'Точность', 'value' => '±0,01 мм'],
                ['label' => 'Материалы', 'value' => 'Акрил, фанера, МДФ, пластик, картон, кожа'],
            ],
        ],

        // 5. Лазер 1080 - sort 5
        [
            'title' => 'CO₂-лазерный станок с ЧПУ 1080 (1000×800 мм)',
            'image' => 'laser-1080.webp',
            'excerpt' => 'Компактный лазерный станок для резки и гравировки. Рабочее поле 1000×800 мм идеально подходит для производства сувениров...',
            'content' => 'Компактный и производительный лазерный станок для цехов с ограниченным пространством. Оптимально подходит для раскроя заготовок под объемные буквы, а также для гравировки и резки акрила, фанеры и пластика. Позволяет выполнять мелкосерийное производство сувениров, табличек и элементов декора с высокой детализацией и скоростью.',
            'category' => EquipmentCategory::LASER,
            'manufacturer' => 'Rayden / APACHI',
            'year' => 2023,
            'sort' => 5,
            'properties' => [
                ['label' => 'Рабочее поле', 'value' => '1000 × 800 мм'],
                ['label' => 'Мощность лазера', 'value' => '80–100 Вт (CO₂)'],
                ['label' => 'Толщина реза', 'value' => 'до 10–12 мм'],
                ['label' => 'Материалы', 'value' => 'Акрил, фанера, МДФ, пластик, кожа, картон'],
            ],
        ],

        // 6. Mimaki JV33 (Плоттер) - sort 6
        [
            'title' => 'Сольвентный плоттер Mimaki JV33-160 BS',
            'image' => 'MimakiJV33-160BS.webp',
            'excerpt' => 'Универсальный сольвентный плоттер 1,6 м для наружной и интерьерной печати...',
            'content' => 'Проверенный временем широкоформатный плоттер для наружной и интерьерной печати. Идеально подходит для изготовления баннеров, сити-лайтов, постеров и изображений для световых коробов. Обеспечивает сочные, насыщенные цвета и четкие линии даже при больших объемах печати. Устойчивость к внешней среде делает его незаменимым для производства долговечной наружной рекламы.',
            'category' => EquipmentCategory::WIDE_FORMAT,
            'manufacturer' => 'Mimaki (Япония)',
            'year' => 2021,
            'sort' => 6,
            'properties' => [
                ['label' => 'Ширина печати', 'value' => '1610 мм'],
                ['label' => 'Разрешение', 'value' => '1440×1440 dpi'],
                ['label' => 'Скорость печати', 'value' => 'до 17,5 м²/ч (режим 540×720 dpi)'],
                ['label' => 'Применение', 'value' => 'Баннеры, интерьерная печать, винил'],
            ],
        ],

        // 7. Mimaki CG-130 (Каттер) - sort 7
        [
            'title' => 'Режущий плоттер (каттер) Mimaki CG-130SR II',
            'image' => 'Mimaki-CG-130SRII.webp',
            'excerpt' => 'Профессиональный режущий плоттер с сервоприводом для контурной резки пленок, бумаги и картона.',
            'content' => 'Профессиональный режущий плоттер для высокоточной вырезки наклеек, аппликаций и трафаретов. Оснащен системой автоматического распознавания меток для контурной резки ранее напечатанных изображений. Позволяет создавать сложные аппликации из цветных, световых и витражных пленок, а также идеально ровные буквы и логотипы.',
            'category' => EquipmentCategory::WIDE_FORMAT,
            'manufacturer' => 'Mimaki (Япония)',
            'year' => 2022,
            'sort' => 7,
            'properties' => [
                ['label' => 'Ширина резки', 'value' => '1300 мм'],
                ['label' => 'Точность', 'value' => '±0,1 мм (контурная резка)'],
                ['label' => 'Давление ножа', 'value' => 'Прецизионная регулировка'],
                ['label' => 'Особенности', 'value' => 'Автоподрезка углов, сенсор меток'],
            ],
        ],

        // 8. GMP Excelam (Горячий ламинатор) - sort 8
        [
            'title' => 'Рулонный ламинатор GMP Excelam Q1670RS',
            'image' => 'GMPExcelamQ1670RS.webp',
            'excerpt' => 'Профессиональный двухсторонний ламинатор с шириной 1670 мм для горячего и холодного ламинирования.',
            'content' => 'Профессиональное оборудование для финишной обработки широкоформатной рекламы. Выполняет горячее ламинирование для защиты изображений от УФ-лучей, влаги и механических повреждений, а также холодную накатку пленки на жесткие основы. Равномерный прогрев валов исключает появление пузырей и складок, гарантируя идеальное покрытие даже на больших тиражах.',
            'category' => EquipmentCategory::LAMINATION,
            'manufacturer' => 'GMP Germany GmbH (Германия)',
            'year' => 2022,
            'sort' => 8,
            'properties' => [
                ['label' => 'Макс. ширина', 'value' => '1670 мм'],
                ['label' => 'Режимы', 'value' => 'Горячее / Холодное ламинирование'],
                ['label' => 'Температура', 'value' => 'до 160 °C'],
                ['label' => 'Толщина материала', 'value' => 'до 12 мм'],
            ],
        ],

        // 9. Холодный ламинатор - sort 9
        [
            'title' => 'Рулонный ламинатор холодного ламинирования (1600 мм)',
            'image' => 'cold-laminator-1600.webp',
            'excerpt' => 'Профессиональный ламинатор для холодного ламинирования и накатки пленки на жесткие основы.',
            'content' => 'Широкоформатный ламинатор для холодного ламинирования и накатки пленки на жесткие основы (ПВХ, пенокартон, композит). Идеально подходит для защиты интерьерной печати и создания аппликаций без использования нагрева, что позволяет работать с термочувствительными материалами. Равномерное давление по всей ширине вала исключает образование дефектов покрытия.',
            'category' => EquipmentCategory::LAMINATION,
            'manufacturer' => 'GMP / R-SuperLam',
            'year' => 2023,
            'sort' => 9,
            'properties' => [
                ['label' => 'Макс. ширина', 'value' => '1600 мм'],
                ['label' => 'Тип', 'value' => 'Холодное ламинирование / Накатка'],
                ['label' => 'Макс. толщина', 'value' => '20–30 мм'],
                ['label' => 'Привод', 'value' => 'Пневматический / Ручной'],
            ],
        ],

        // 10. UV DTF-принтер - sort 10
        [
            'title' => 'Рулонный UV DTF-принтер AinkJet AJ-600E Pro (60см)',
            'image' => 'AinkJet-AJ-600E-Pro.webp',
            'excerpt' => 'Современный UV DTF-принтер для печати наклеек с прямым переносом на любые поверхности...',
            'content' => 'Инновационное решение для производства универсальных наклеек без вырубки по контуру. Технология UV DTF позволяет наносить яркие, полноцветные изображения с белой подложкой и защитным лаком на любые поверхности: дерево, стекло, металл, пластик и кожу. Идеально подходит для брендирования сувениров, нанесения логотипов на сложные поверхности и создания интерьерных наклеек.',
            'category' => EquipmentCategory::UV_PRINT,
            'manufacturer' => 'AinkJet (Китай)',
            'year' => 2024,
            'sort' => 10,
            'properties' => [
                ['label' => 'Ширина печати', 'value' => '600 мм'],
                ['label' => 'Цвета', 'value' => 'CMYK + White + Varnish (лак)'],
                ['label' => 'Технология', 'value' => 'Прямой перенос (DTF)'],
                ['label' => 'Поверхности', 'value' => 'Дерево, стекло, металл, пластик, кожа'],
            ],
        ],

        // 11. 3D-принтер - sort 11 (⚠️ ВРЕМЕННОЕ РЕШЕНИЕ)
        [
            'title' => 'Промышленный 3D-принтер (1200×600×450 мм)',
            'image' => '3d-printer-large.webp',
            'excerpt' => 'Крупноформатный 3D-принтер для печати прототипов рекламных конструкций, оснастки и крупных деталей.',
            'content' => 'Крупноформатный 3D-принтер для создания прототипов и сложных объемных элементов, которые невозможно или слишком долго изготавливать вручную. Позволяет быстро напечатать полноразмерные макеты вывесок, декоративные элементы и оснастку для вакуумной формовки. Значительно ускоряет процесс согласования дизайн-проектов с заказчиками благодаря созданию реалистичных образцов.',
            'category' => EquipmentCategory::MILLING, // ВРЕМЕННО! Нужно добавить PROTO в Enum
            'manufacturer' => 'Уточняется',
            'year' => 2024,
            'sort' => 11,
            'properties' => [
                ['label' => 'Технология', 'value' => 'FDM (крупноформатная печать)'],
                ['label' => 'Область построения', 'value' => '1200 × 600 × 450 мм'],
                ['label' => 'Детализация', 'value' => 'Сопло 0,4–0,8 мм'],
                ['label' => 'Материалы', 'value' => 'ABS, PLA, PETG, композиты'],
            ],
        ],
    ];

    public function run(): void
    {
        Equipment::truncate();

        foreach ($this->items as $item) { // ← исправлено: было $this->items, теперь $item

            $attachment = Attachment::where('original_name', $item['image'])->first();

            if (! $attachment) {
                $this->command->warn("Изображение {$item['image']} не найдено в базе аттачей, оборудование {$item['title']} пропущено");

                continue;
            }

            $equipment = Equipment::create([
                'title' => $item['title'], // ← исправлено
                'slug' => Str::slug($item['title']), // ← исправлено
                'excerpt' => $item['excerpt'], // ← исправлено
                'content' => $item['content'], // ← исправлено
                'category' => $item['category'] instanceof EquipmentCategory
                    ? $item['category']->value
                    : $item['category'], // ← исправлено: добавил проверку на enum/строку
                'manufacturer' => $item['manufacturer'], // ← исправлено
                'year' => $item['year'], // ← исправлено
                'properties' => $item['properties'], // ← исправлено
                'preview_id' => $attachment->id,
                'detail_id' => $attachment->id,
                'sort' => $item['sort'], // ← исправлено
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $this->command->info("✓ Создано оборудование: {$item['title']} (sort: {$item['sort']})");
        }
    }
}

```

### database/seeders/FAQSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\FAQ;
use App\Models\FaqCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    /**
     * Структура данных:
     * category_excerpt - соответствует полю excerpt из FaqCategorySeeder
     * questions - массив вопросов для данной категории
     */
    protected array $items = [
        [
            'category_excerpt' => 'faq_main',
            'questions' => [
                'Вы работаете с физическими лицами или только с юридическими?',
                'Работаете ли вы за пределами Москвы?',
                'Насколько вы загружены? Когда вы сможете взяться за мой заказ?',
                'Можно ли приехать в офис или цех и обсудить проект лично?',
                'Берётесь ли вы за маленькие заказы (1–3 буквы)?',
                'Нужно ли согласовывать вывеску с городскими властями?',
            ],
        ],
        [
            'category_excerpt' => 'faq_price',
            'questions' => [
                'Почему нет фиксированного прайса на все изделия?',
                'Каков порядок оплаты?',
                'Есть ли скидки за объём или постоянным клиентам?',
                'Входит ли монтаж в стоимость или оплачивается отдельно?',
                'Что произойдёт, если стоимость изменится после подписания договора?',
            ],
        ],
        [
            'category_excerpt' => 'faq_production',
            'questions' => [
                'Какой минимальный размер буквы вы делаете?',
                'Какие материалы вы используете?',
                'Как долго изготавливается вывеска?',
                'Можно ли ускорить производство?',
                'Получу ли я фото готового изделия до монтажа?',
                'Выдержат ли буквы российский климат — мороз, дождь, снег?',
            ],
        ],
        [
            'category_excerpt' => 'faq_design',
            'questions' => [
                'В каком формате предоставить логотип или макет?',
                'Разрабатываете ли вы дизайн вывески с нуля?',
                'Показываете ли вы визуализацию вывески на фасаде до производства?',
                'Могу ли я использовать любой шрифт?',
                'Предоставляете ли вы файлы после изготовления заказа?',
            ],
        ],
        [
            'category_excerpt' => 'faq_installation',
            'questions' => [
                'Как крепится вывеска к фасаду?',
                'Нужно ли готовить объект к монтажу?',
                'Используете ли вы подъёмное оборудование для высотного монтажа?',
                'Что происходит, если при монтаже что-то повреждается?',
            ],
        ],
        [
            'category_excerpt' => 'faq_guarantee',
            'questions' => [
                'Какая гарантия на вывески?',
                'Как быстро вы реагируете при гарантийных случаях?',
                'Можно ли заменить сгоревшие LED-ленты самостоятельно?',
                'Предоставляете ли вы техническое обслуживание после окончания гарантии?',
                'Даёте ли вы какой-то документ на изделие?',
            ],
        ],
    ];

    /**
     * Ответы на вопросы (сопоставлены с вопросами по индексам)
     */
    protected array $answers = [
        // Общие вопросы (faq_main)
        [
            '<p>Мы работаем и с физическими, и с юридическими лицами: ООО, ИП, самозанятые. Для физических лиц оформляем договор на оказание услуг, принимаем оплату наличными или переводом на карту. Для юридических — полный пакет закрывающих документов, НДС, электронный документооборот.</p>',

            '<p>Производство находится в Москве. Доставку готовых изделий осуществляем по всей России через транспортные компании (СДЭК, Деловые линии и др.).</p><p>Монтаж — в Москве и МО нашими бригадами. В других регионах работаем через проверенных партнёров-монтажников с нашим контролем качества на всех этапах.</p>',

            '<p>Мы принимаем заказы постоянно. После первого обращения менеджер ответит в течение 15 минут и сориентирует по текущей загрузке и ближайшим доступным срокам. Как правило, запуск в производство — в течение 1–3 рабочих дней после подписания договора.</p>',

            '<p>Да, мы приветствуем личные встречи. Вы можете приехать на производство, посмотреть оборудование и образцы материалов. Запишитесь на удобное время по телефону +7 (495) 123-45-67 или напишите в мессенджер.</p><p>Адрес: г. Москва, ул. Производственная, д. 15, стр. 2. Пн–Пт: 9:00–18:00.</p>',

            '<p>Да, минимального размера заказа нет. Мы делаем как единственную букву или логотип, так и крупные партии для сетей. Для небольших заказов стоимость одной буквы может быть выше из-за неделимых затрат на разработку макета и наладку оборудования — об этом честно предупредим на этапе расчёта.</p>',

            '<p>В большинстве случаев — да. Наружная реклама на фасадах зданий требует согласования с местной администрацией или управляющей компанией здания. Интерьерные вывески согласования не требуют.</p><p>Мы помогаем подготовить необходимый пакет документов (эскиз, техпаспорт изделия, схему размещения) — эта услуга включена в комплексный заказ бесплатно.</p>',
        ],

        // Цены и оплата (faq_price)
        [
            '<p>Стоимость вывески зависит от десятков параметров: материал, размер, толщина, тип подсветки, сложность шрифта, количество деталей, тип монтажа. Одна буква «А» высотой 200 мм и 2000 мм из акрила — совершенно разные изделия по трудоёмкости.</p><p>Мы указываем начальные цены (от …) и всегда рассчитываем точную стоимость бесплатно в течение 1 рабочего дня.</p>',

            '<p>Стандартная схема: 50% предоплата перед запуском производства, 50% после монтажа и подписания акта приёма-передачи. Для небольших заказов (до 15 000 ₽) возможна 100% предоплата с соответствующей скидкой.</p><p>Принимаем наличные, банковский перевод, оплату картой. Юридическим лицам — счёт с НДС или без (в зависимости от системы налогообложения).</p>',

            '<p>Да. При заказе от 50 букв одной партии — скидка 10%. При заказе от 100 букв — скидка 15%. Для постоянных клиентов после 3-го заказа — персональные условия на усмотрение менеджера.</p><p>Для сетевых клиентов (несколько точек) всегда согласовываем специальные условия — свяжитесь с нами для детального обсуждения.</p>',

            '<p>Монтаж всегда оплачивается отдельно — его стоимость зависит от высоты, типа фасада, удалённости объекта и сложности работ. Минимальная стоимость — от 3 500 ₽.</p><p>Точная стоимость монтажа указывается в коммерческом предложении после выезда технолога на замер. Выезд на замер — бесплатный.</p>',

            '<p>Стоимость, зафиксированная в договоре, не меняется. Если в процессе производства возникают непредвиденные обстоятельства (например, изменение состава работ по вашей инициативе), мы согласуем дополнительное соглашение с новой суммой до начала изменений.</p>',
        ],

        // Производство (faq_production)
        [
            '<p>Минимальная высота объёмной буквы с подсветкой — 50 мм. Для плоских букв (без объёма) — от 20 мм. Для очень мелких надписей рекомендуем гравировку — это точнее и экономичнее.</p>',

            '<p>Работаем с широким спектром материалов:</p><ul><li>Акрил (литой и экструзионный) — Plexiglas, Altuglas</li><li>Нержавеющая сталь (полированная, матовая, зеркальная)</li><li>Алюминий листовой с порошковым покрытием</li><li>Вспененный и листовой ПВХ</li><li>МДФ и натуральное дерево</li><li>Гибкий LED-неон</li></ul><p>Подбираем материал исходя из задачи, бюджета и условий эксплуатации.</p>',

            '<p>Сроки зависят от сложности:</p><ul><li>Плоские буквы из ПВХ/акрила без подсветки — 2–4 дня</li><li>Объёмные буквы с LED-подсветкой — 5–7 дней</li><li>Буквы из нержавейки — 7–12 дней</li><li>Сложные фасадные конструкции — 14–21 день</li><li>Крупные партии для сетей — по согласованию</li></ul><p>Срок считается с момента подписания договора и утверждения макета.</p>',

            '<p>Да, принимаем срочные заказы. Для этого заказ ставится в приоритетную очередь, может выполняться в ночную смену. Стоимость срочности — +20–30% к цене. Уточняйте возможность при оформлении заказа.</p>',

            '<p>Да, обязательно. После изготовления мы отправляем фотоотчёт — готовые буквы в цеху, включая включённую подсветку. Если что-то не устраивает — устраним до выезда бригады на объект. Это стандартная часть нашего процесса приёмки.</p>',

            '<p>Да. Для наружных изделий используем герметик по периметру, блоки питания с защитой IP67, нержавеющий крепёж. Рабочий диапазон температур: от −40°C до +60°C. Акрил не желтеет и не трескается в таком диапазоне при правильной эксплуатации. Срок службы хорошей наружной вывески — 10–15 лет.</p>',
        ],

        // Дизайн и макеты (faq_design)
        [
            '<p>Принимаем в векторном формате: AI, EPS, SVG, PDF (с сохранёнными контурами шрифтов). Это идеальный вариант — сразу передаём на производство.</p><p>Если векторного файла нет — присылайте любое изображение хорошего качества (PNG, JPG от 300 dpi). Наши дизайнеры оцифруют его в вектор. Стоимость оцифровки — от 1 500 ₽, при заказе изделий — бесплатно.</p>',

            '<p>Да. Если у вас нет логотипа или вы хотите разработать новый стиль — наш дизайнер подготовит несколько вариантов концепций вывески с учётом вашего бренда, фасада и пожеланий. Разработка дизайна — от 2 500 ₽, при размещении заказа включается в стоимость.</p>',

            '<p>Да, это стандартный шаг перед запуском в производство. Дизайнер монтирует изображение вывески на фотографию вашего фасада, чтобы вы могли оценить итоговый вид. Вносим правки до вашего полного одобрения — без ограничений на количество итераций.</p>',

            '<p>Практически любой. Мы работаем с любым шрифтом, который можно перевести в вектор. Единственное ограничение — тонкие засечки и очень узкие элементы шрифта при маленьком размере буквы: они могут не получиться чёткими. Наш технолог подскажет, если шрифт потребует адаптации.</p>',

            '<p>Да. По запросу передаём векторный файл финального макета (AI или PDF) и визуализацию на фасаде в высоком разрешении. Производственные файлы (программы ЧПУ) являются нашей интеллектуальной собственностью и не передаются.</p>',
        ],

        // Монтаж (faq_installation)
        [
            '<p>Способ крепления зависит от типа фасада и конструкции:</p><ul><li>На кирпич или бетон — дюбель-анкеры через шпильки</li><li>На вентилируемый фасад — через планки или кляммеры</li><li>На стекло — специальные крепежи с силиконовыми прокладками</li><li>На гипсокартон или лёгкие перегородки — закладные детали в стену</li></ul><p>Технолог выбирает оптимальный способ после осмотра объекта.</p>',

            '<p>Как правило, от вас требуется только обеспечить доступ к объекту и наличие розетки 220V на фасаде или вблизи него (для вывесок с подсветкой). Всё остальное — наша забота. Если электропроводку нужно провести, уточните — помогаем и с этим.</p>',

            '<p>Да. До 5 метров работаем с лестницами и строительными козлами. Выше — привлекаем автовышку или промышленных альпинистов. Стоимость высотного монтажа рассчитывается отдельно и включается в смету.</p>',

            '<p>Все монтажные работы выполняются застрахованными бригадами. В случае повреждения изделия по вине наших сотрудников — изготовим и установим замену за наш счёт. В случае повреждения фасада — компенсируем ущерб. Подробные условия — в договоре.</p>',
        ],

        // Гарантия и сервис (faq_guarantee)
        [
            '<p>Гарантия 12 месяцев на всю конструкцию — акриловые панели, металлические борта, крепления. Гарантия 12 месяцев на LED-подсветку и блоки питания. Гарантия 6 месяцев на монтажные работы.</p><p>Гарантийные случаи: заводские дефекты материалов, отказ LED, нарушение герметичности. Не являются гарантийными: механические повреждения по вине третьих лиц, вандализм, форс-мажор.</p>',

            '<p>Первичная реакция — в течение 2 рабочих часов (по рабочим дням). Выезд специалиста — в течение 48 часов после подтверждения гарантийного случая. Для критичных случаев (крупные клиенты, сетевые проекты) предусмотрено обслуживание в тот же день.</p>',

            '<p>Теоретически — да, если у вас есть опыт работы с электрикой и LED. Практически — не рекомендуем, так как это может аннулировать гарантию и привести к неравномерному свечению при использовании неоригинальных компонентов. Лучше вызвать нашего специалиста — это быстро и часто бесплатно в гарантийный период.</p>',

            '<p>Да. После окончания гарантийного срока мы предоставляем платное техобслуживание: замена LED-ленты, блоков питания, ремонт механических повреждений. Стоимость — по фактическим работам. Для постоянных клиентов — приоритетная запись и сниженные ставки на запчасти.</p>',

            '<p>Да. После монтажа передаём:</p><ul><li>Гарантийный талон с датой монтажа и сроками гарантии</li><li>Паспорт изделия с техническими характеристиками</li><li>Инструкцию по эксплуатации и уходу</li><li>Акт приёма-передачи работ</li></ul><p>Для юридических лиц также предоставляем полный пакет бухгалтерских документов.</p>',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $globalIndex = 0;

        foreach ($this->items as $categoryIndex => $categoryData) {
            // Находим категорию по excerpt
            $category = FaqCategory::where('excerpt', $categoryData['category_excerpt'])->first();

            if (! $category) {
                $this->command->error("Категория с excerpt '{$categoryData['category_excerpt']}' не найдена. Пропускаем...");

                continue;
            }

            // Получаем ответы для текущей категории
            $categoryAnswers = $this->answers[$categoryIndex] ?? [];

            foreach ($categoryData['questions'] as $questionIndex => $question) {
                // Получаем соответствующий ответ (по индексу вопроса)
                $answer = $categoryAnswers[$questionIndex] ?? '<p>Ответ скоро появится.</p>';

                FAQ::create([
                    'title' => $question,
                    'slug' => Str::slug($question),
                    'excerpt' => $answer,
                    'category_id' => $category->id,
                    'sort' => $questionIndex + 1,
                    'active' => true,
                    'published_at' => Carbon::now(),
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);

                $globalIndex++;

                $this->command->info("Создан вопрос FAQ [{$globalIndex}]: ".mb_substr($question, 0, 50).'...');
            }
        }

        $this->command->info("Всего создано вопросов: {$globalIndex}");
    }
}

```

### database/seeders/FaqCategorySeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqCategorySeeder extends Seeder
{
    protected array $items = [

        [
            'title' => 'Общие вопросы',
            'excerpt' => 'faq_main',
        ],
        [
            'title' => 'Цены и оплата',
            'excerpt' => 'faq_price',
        ],
        [
            'title' => 'Производство',
            'excerpt' => 'faq_production',
        ],
        [
            'title' => 'Дизайн и макеты',
            'excerpt' => 'faq_design',
        ],
        [
            'title' => 'Монтаж',
            'excerpt' => 'faq_installation',
        ],
        [
            'title' => 'Гарантия и сервис',
            'excerpt' => 'faq_guarantee',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->items as $index => $item) {

            FaqCategory::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['excerpt'],
                'sort' => $index + 1,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $this->command->info("Создана категория FAQ: {$item['title']}");
        }
    }
}

```

### database/seeders/LeadSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Enums\LeadPriority;
use App\Enums\LeadStatus;
use App\Enums\PreferredContact;
use App\Enums\RequestType;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Lead;
use App\Models\LeadStatusHistory;
use App\Models\LeadTask;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем или создаем менеджеров
        $managers = User::whereHas('roles', function ($query) {
            $query->where('slug', 'manager');
        })->get();

        if ($managers->isEmpty()) {
            $manager = User::factory()->create([
                'name' => 'Менеджер Иванов',
                'email' => 'manager@narrative.ru',
                'password' => bcrypt('password'),
            ]);
            $manager->roles()->attach(2); // предполагаем, что role_id=2 для менеджера

            $managers = collect([$manager]);
        }

        // Создаем 50 тестовых заявок
        for ($i = 1; $i <= 50; $i++) {
            $status = $this->getRandomStatus();
            $priority = $this->getRandomPriority();
            $requestType = $this->getRandomRequestType();
            $createdAt = Carbon::now()->subDays(rand(1, 30));

            $lead = Lead::create([
                'lead_number' => 'LEAD-'.date('Y').date('m').'-'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => $this->getRandomName(),
                'phone' => '+7'.rand(900, 999).rand(1000000, 9999999),
                'email' => 'client'.$i.'@example.com',
                'company_name' => rand(0, 1) ? $this->getRandomCompany() : null,
                'position' => rand(0, 1) ? $this->getRandomPosition() : null,
                'telegram' => rand(0, 1) ? '@user'.$i : null,
                'whatsapp' => rand(0, 1) ? '+7'.rand(900, 999).rand(1000000, 9999999) : null,
                'preferred_contact' => $this->getRandomPreferredContact(),
                'request_type' => $requestType,
                'service_type' => $this->getRandomServiceType($requestType),
                'message' => $this->getRandomMessage($requestType),
                'form_data' => $this->generateFormData(),
                'budget_from' => rand(0, 1) ? rand(10000, 50000) : null,
                'budget_to' => rand(0, 1) ? rand(50000, 500000) : null,
                'desired_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 30)) : null,
                'desired_time' => rand(0, 1) ? Carbon::now()->setTime(rand(9, 18), 0) : null,
                'status' => $status,
                'priority' => $priority,
                'source' => $this->getRandomSource(),
                'campaign' => rand(0, 1) ? $this->getRandomCampaign() : null,
                'assigned_to' => rand(0, 1) ? $managers->random()->id : null,
                'assigned_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 5)) : null,
                'processed_by' => rand(0, 1) ? $managers->random()->id : null,
                'processed_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 10)) : null,
                'called_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 3)) : null,
                'next_call_at' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 5)) : null,
                'call_attempts' => rand(0, 3),
                'manager_notes' => rand(0, 1) ? $this->getRandomNote() : null,
                'communication_history' => $this->generateCommunicationHistory(),
                'loss_reason' => $status === LeadStatus::LOST ? $this->getRandomLossReason() : null,
                'ip_address' => rand(0, 1) ? long2ip(rand(0, 4294967295)) : null,
                'user_agent' => rand(0, 1) ? $this->getRandomUserAgent() : null,
                'referrer' => rand(0, 1) ? $this->getRandomReferrer() : null,
                'landing_page' => rand(0, 1) ? $this->getRandomLandingPage() : null,
                'utm_params' => rand(0, 1) ? $this->generateUtmParams() : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt->addDays(rand(1, 5)),
            ]);

            // Создаем историю статусов
            $this->createStatusHistory($lead);

            // Создаем задачи для некоторых лидов
            if (rand(0, 1)) {
                $this->createTasks($lead, $managers);
            }
        }

        $this->command->info('Создано 50 тестовых заявок');
    }

    protected function getRandomStatus(): LeadStatus
    {
        $statuses = LeadStatus::cases();

        return $statuses[array_rand($statuses)];
    }

    protected function getRandomPriority(): LeadPriority
    {
        $priorities = LeadPriority::cases();

        return $priorities[array_rand($priorities)];
    }

    protected function getRandomRequestType(): RequestType
    {
        $types = RequestType::cases();

        return $types[array_rand($types)];
    }

    protected function getRandomPreferredContact(): PreferredContact
    {
        $contacts = PreferredContact::cases();

        return $contacts[array_rand($contacts)];
    }

    protected function getRandomName(): string
    {
        $firstNames = ['Александр', 'Дмитрий', 'Максим', 'Сергей', 'Андрей', 'Алексей', 'Иван', 'Елена', 'Ольга', 'Наталья', 'Татьяна', 'Мария'];
        $lastNames = ['Иванов', 'Петров', 'Сидоров', 'Смирнов', 'Кузнецов', 'Попов', 'Васильев', 'Михайлов', 'Федоров', 'Морозов'];

        return $lastNames[array_rand($lastNames)].' '.$firstNames[array_rand($firstNames)];
    }

    protected function getRandomCompany(): string
    {
        $companies = ['ООО "Ромашка"', 'ИП Иванов', 'АО "ТехноСервис"', 'ООО "СтройИнвест"', 'ЗАО "МедиаГрупп"', 'ООО "РекламаПро"'];

        return $companies[array_rand($companies)];
    }

    protected function getRandomPosition(): string
    {
        $positions = ['Генеральный директор', 'Коммерческий директор', 'Маркетолог', 'Менеджер по рекламе', 'Собственник', 'Начальник отдела маркетинга'];

        return $positions[array_rand($positions)];
    }

    protected function getRandomServiceType(RequestType $type): string
    {
        $services = [
            RequestType::CALCULATE->value => ['Наружная реклама', 'Вывески', 'Баннеры', 'Штендеры', 'Световые короба'],
            RequestType::ORDER->value => ['Рекламный щит 3x6', 'Вывеска на фасад', 'Баннер на заборе', 'Световой короб'],
            RequestType::QUESTION->value => ['Цены на монтаж', 'Сроки изготовления', 'Материалы', 'Дизайн-проект'],
            RequestType::CONSULTATION->value => ['По наружной рекламе', 'По разрешительной документации', 'По согласованию'],
            RequestType::CALLBACK->value => ['Уточнить детали', 'Записаться на встречу'],
        ];

        $list = $services[$type->value] ?? $services[RequestType::CALCULATE->value];

        return $list[array_rand($list)];
    }

    protected function getRandomMessage(RequestType $type): string
    {
        $messages = [
            RequestType::CALCULATE->value => [
                'Нужен расчет стоимости вывески на фасад',
                'Сколько будет стоить изготовление баннера 3x6?',
                'Рассчитайте пожалуйста стоимость рекламного щита',
            ],
            RequestType::ORDER->value => [
                'Хочу заказать вывеску для магазина',
                'Нужен срочный заказ светового короба',
                'Заказать изготовление рекламной конструкции',
            ],
            RequestType::QUESTION->value => [
                'Какие сроки изготовления?',
                'Делаете согласование с администрацией?',
                'Какие гарантии на монтаж?',
            ],
            RequestType::CONSULTATION->value => [
                'Нужна консультация по наружной рекламе',
                'Помогите выбрать тип вывески',
                'Хочу узнать подробнее о ваших услугах',
            ],
            RequestType::CALLBACK->value => [
                'Позвоните мне в рабочее время',
                'Жду звонка для уточнения деталей',
                'Перезвоните как будет возможность',
            ],
        ];

        $list = $messages[$type->value] ?? $messages[RequestType::CALLBACK->value];

        return $list[array_rand($list)];
    }

    protected function getRandomSource(): string
    {
        $sources = ['website', 'yandex_direct', 'google_ads', 'instagram', 'telegram', 'referral', 'call', 'email'];

        return $sources[array_rand($sources)];
    }

    protected function getRandomCampaign(): string
    {
        $campaigns = ['brand', 'retargeting', 'season_sale', 'new_year', 'summer'];

        return $campaigns[array_rand($campaigns)];
    }

    protected function getRandomNote(): string
    {
        $notes = [
            'Клиент хочет обсудить детали лично',
            'Просил перезвонить после 15:00',
            'Интересуется оптовыми ценами',
            'Нужно подготовить коммерческое предложение',
            'Клиент настроен решительно, высокая вероятность сделки',
            'Перезвонить через неделю',
        ];

        return $notes[array_rand($notes)];
    }

    protected function getRandomLossReason(): string
    {
        $reasons = [
            'Не сошлись в цене',
            'Выбрали конкурентов',
            'Ппередумали делать рекламу',
            'Нет бюджета',
            'Не устроили сроки',
            'Сменили направление бизнеса',
        ];

        return $reasons[array_rand($reasons)];
    }

    protected function getRandomUserAgent(): string
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15',
            'Mozilla/5.0 (Linux; Android 10; SM-G975F) AppleWebKit/537.36',
        ];

        return $agents[array_rand($agents)];
    }

    protected function getRandomReferrer(): string
    {
        $referrers = [
            'https://yandex.ru/search/',
            'https://www.google.com/search',
            'https://www.instagram.com/',
            'https://t.me/',
            'https://vk.com/',
            'direct',
        ];

        return $referrers[array_rand($referrers)];
    }

    protected function getRandomLandingPage(): string
    {
        $pages = [
            '/',
            '/services/outdoor',
            '/products/billboards',
            '/portfolio',
            '/contacts',
            '/calculator',
        ];

        return $pages[array_rand($pages)];
    }

    protected function generateFormData(): array
    {
        return [
            'form_id' => 'contact_form_'.rand(1, 5),
            'form_name' => 'Форма обратной связи',
            'fields' => [
                'name' => 'value',
                'phone' => 'value',
                'comment' => 'comment text',
            ],
        ];
    }

    protected function generateUtmParams(): array
    {
        return [
            'utm_source' => $this->getRandomSource(),
            'utm_medium' => rand(0, 1) ? 'cpc' : 'organic',
            'utm_campaign' => $this->getRandomCampaign(),
            'utm_content' => 'ad_'.rand(1, 100),
            'utm_term' => 'keyword_'.rand(1, 10),
        ];
    }

    protected function generateCommunicationHistory(): array
    {
        $history = [];
        $events = rand(0, 5);

        for ($i = 0; $i < $events; $i++) {
            $history[] = [
                'type' => rand(0, 1) ? 'call' : 'note',
                'date' => Carbon::now()->subDays(rand(1, 10))->format('Y-m-d H:i:s'),
                'description' => $this->getRandomNote(),
            ];
        }

        return $history;
    }

    protected function createStatusHistory(Lead $lead): void
    {
        $statuses = LeadStatus::cases();
        $statusCount = rand(1, min(3, count($statuses)));

        // Выбираем случайные статусы для истории
        $statusIndices = array_rand(range(0, count($statuses) - 1), $statusCount);
        if (! is_array($statusIndices)) {
            $statusIndices = [$statusIndices];
        }
        sort($statusIndices);

        for ($i = 0; $i < $statusCount; $i++) {
            // Создаем новый экземпляр модели
            $history = new LeadStatusHistory;

            // Заполняем поля по одному
            $history->lead_id = $lead->id;
            $history->new_status = $statuses[$statusIndices[$i]];
            $history->created_at = Carbon::parse($lead->created_at)->addDays($i);
            $history->updated_at = Carbon::parse($lead->created_at)->addDays($i);

            if ($i > 0) {
                $history->old_status = $statuses[$statusIndices[$i - 1]];
            }

            if (rand(0, 1)) {
                $history->comment = 'Автоматическое изменение статуса';
            }

            // Добавляем created_by и updated_by если есть пользователь
            if (Auth::check()) {
                $history->created_by = Auth::id();
                $history->updated_by = Auth::id();
            }
            // Включаем логирование запросов
            DB::enableQueryLog();

            try {
                // Пытаемся сохранить
                $result = $history->save();

            } catch (\Exception $e) {
                $this->command->error('Ошибка при save(): '.$e->getMessage());

                // Получаем последний запрос
                $queries = DB::getQueryLog();
                $lastQuery = end($queries);

                $this->command->error('Последний SQL запрос:');
                $this->command->error('SQL: '.($lastQuery['query'] ?? 'N/A'));
                $this->command->error('Bindings: '.json_encode($lastQuery['bindings'] ?? [], JSON_UNESCAPED_UNICODE));
                $this->command->error('Time: '.($lastQuery['time'] ?? 'N/A'));

                throw $e;
            }
        }
    }

    protected function createTasks(Lead $lead, $managers): void
    {
        $taskCount = rand(1, 3);

        for ($i = 0; $i < $taskCount; $i++) {
            $status = rand(0, 2) ? TaskStatus::PENDING : TaskStatus::COMPLETED;

            LeadTask::create([
                'lead_id' => $lead->id,
                'title' => $this->getRandomTaskTitle(),
                'description' => rand(0, 1) ? $this->getRandomTaskDescription() : null,
                'status' => $status,
                'priority' => $this->getRandomTaskPriority(),
                'due_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 7)) : null,
                'assigned_to' => rand(0, 1) ? $managers->random()->id : null,
                'completed_at' => $status === TaskStatus::COMPLETED ? Carbon::now() : null,
            ]);
        }
    }

    protected function getRandomTaskTitle(): string
    {
        $titles = [
            'Позвонить клиенту',
            'Подготовить КП',
            'Отправить договор',
            'Согласовать макет',
            'Уточнить детали',
            'Напомнить о встрече',
        ];

        return $titles[array_rand($titles)];
    }

    protected function getRandomTaskDescription(): string
    {
        $descriptions = [
            'Обсудить детали проекта',
            'Уточнить требования к макету',
            'Подготовить смету с учетом пожеланий',
            'Согласовать сроки выполнения',
            'Выслать примеры работ',
        ];

        return $descriptions[array_rand($descriptions)];
    }

    protected function getRandomTaskPriority(): TaskPriority
    {
        $priorities = TaskPriority::cases();

        return $priorities[array_rand($priorities)];
    }
}

```

### database/seeders/MaterialSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MaterialSeeder extends Seeder
{
    protected array $items = [
        [
            'title' => 'Акрил',
            'icon' => 'material-acril',
            'text' => 'Литой и экструзионный. Цветной, прозрачный, молочный. Поставщик: Altuglas, Plexiglas.',
            'properties' => ['Объёмные буквы', 'Лайтбоксы', 'Акрилайты'],
        ],
        [
            'title' => 'Алюминий и сталь',
            'icon' => 'material-aluminium',
            'text' => 'Листовой и профильный алюминий, нержавеющая и оцинкованная сталь разной толщины.',
            'properties' => ['Каркасы', 'Лицевые панели', 'Крепёж'],
        ],
        [
            'title' => 'Композитные панели',
            'icon' => 'material-composit',
            'text' => 'Алюкобонд, HPL, Alucobest. Для облицовки фасадов и крупных плоских конструкций.',
            'properties' => ['Фасады', 'Стенды'],
        ],
        [
            'title' => 'ПВХ и ПЭТ',
            'icon' => 'material-pvcpet',
            'text' => 'Листовой ПВХ разной толщины (от 1 до 10 мм), вспененный ПВХ, плёнки для плоттерной резки.',
            'properties' => ['Таблички', 'Буквы', 'Декор'],
        ],
        [
            'title' => 'МДФ и дерево',
            'icon' => 'material-mdfwood',
            'text' => 'МДФ, фанера, массив дерева для интерьерных декоров, рельефных панелей, нестандартных конструкций.',
            'properties' => ['Интерьер', 'Декор', 'Навигация'],
        ],
        [
            'title' => 'Плёнки Oracal / Avery',
            'icon' => 'material-oracal',
            'text' => 'Монтажные, декоративные, зеркальные, флуоресцентные плёнки для плоттерной резки и оклейки.',
            'properties' => ['Брендирование', 'Витрины'],
        ],
        [
            'title' => 'LED-компоненты',
            'icon' => 'material-led',
            'text' => 'Светодиодные ленты и модули Samsung, Epistar. Блоки питания Meanwell — промышленного класса.',
            'properties' => ['Подсветка', 'Световые короба'],
        ],
        [
            'title' => 'Баннерная ткань',
            'icon' => 'material-fabric',
            'text' => 'Суперсет, фронтлит, блэкаут, сетка — всё для широкоформатной печати наружного и интерьерного применения.',
            'properties' => ['Баннеры', 'Стенды'],
        ],
    ];

    public function run(): void
    {
        Material::truncate();

        foreach ($this->items as $index => $item) {
            Material::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['icon'],
                'content' => $item['text'],
                'properties' => $item['properties'],
                'sort' => $index + 1,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $this->command->info("Создано преимущество: {$item['title']}");
        }
    }
}

```

### database/seeders/PageSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Orchid\Attachment\Models\Attachment;

class PageSeeder extends Seeder
{
    protected array $pages = [
        [
            'title' => 'О компании',
            'slug' => 'about',
            'content' => <<<'HTML'
            <h2>Начинали как студия дизайна — выросли в полноцикловое производство</h2>
            <p>Компания «Нарратив» основана в 2010 году. Тогда мы были небольшой командой дизайнеров, которые хотели
                делать рекламу иначе — не просто «чтобы висело», а так, чтобы вывеска рассказывала историю бренда.
            </p>
            <p>Сегодня у нас собственный производственный цех площадью 800 м², современный парк оборудования —
                фрезерные и лазерные станки, широкоформатная и УФ-печать. Мы делаем всё сами: от эскиза до монтажа
                на высоте.</p>
            <p>За эти годы мы поняли главное: хорошая вывеска — это не просто конструкция. Это визуальный голос
                вашего бренда. Именно поэтому наша компания называется «Нарратив» — мы создаём нарративы для
                бизнеса.</p>
            HTML,
            'excerpt' => 'Наша история',
            'preview' => 'about_hero.webp',
            'detail' => 'about_intro.webp',
            'properties' => null,
        ],
        [
            'title' => 'Оборудование и технологии',
            'slug' => 'equipment',
            'content' => <<<'HTML'
            <h2>Мы контролируем каждый этап производства</h2>
            <p>Мы намеренно не отдаём ничего на субподряд. Каждый станок в нашем цехе — это контроль над качеством,
                сроками и стоимостью. Нет посредников — нет искажений.</p>
            <p>Инвестируем в оборудование регулярно: за последние 3 года цех обновился на 60%. Это не только улучшение качества
                — это возможность браться за задачи, которые другие не могут выполнить.</p>
            <p>Результат: точность ±0,05 мм на лазере, рабочее поле до 3×2 метра на фрезере, цикл производства сложной конструкции от 3 дней.</p>
            HTML,
            'excerpt' => 'Наш подход',
            'preview' => 'equipment_hero.webp',
            'detail' => 'equipment_intro.webp',
            'properties' => [
                ['value' => '800', 'key' => 'м² цеха'],
                ['value' => '7', 'key' => 'единиц ЧПУ-оборудования'],
                ['value' => '3', 'key' => 'дня минимальный срок'],
                ['value' => '0,05', 'key' => 'мм точность лазера'],
            ],
        ],
        [
            'title' => 'Блог',
            'slug' => 'blog',
            'content' => '',
            'excerpt' => 'Экспертный контент',
            'preview' => 'blog_hero.webp',
            'detail' => 'blog_intro.webp',
            'properties' => null,
        ],
        [
            'title' => 'Контакты',
            'slug' => 'contacts',
            'content' => 'Мы всегда готовы ответить на ваши вопросы. Звоните, пишите или приезжайте к нам в офис.',
            'excerpt' => 'Свяжитесь с нами',
            'preview' => 'contacts_hero.webp',
            'detail' => 'contacts_intro.webp',
            'properties' => null,
        ],
        [
            'title' => 'FAQ',
            'slug' => 'faq',
            'content' => '',
            'excerpt' => '',
            'preview' => 'faq_hero.webp',
            'detail' => 'faq_intro.webp',
            'properties' => null,
        ],
        [
            'title' => 'Портфолио',
            'slug' => 'portfolio',
            'content' => '',
            'excerpt' => '',
            'preview' => 'portfolio_hero.webp',
            'detail' => 'portfolio_intro.webp',
            'properties' => [
                ['value' => '500+', 'key' => 'реализованных проектов'],
                ['value' => '15', 'key' => 'лет на рынке'],
                ['value' => '98%', 'key' => 'довольных клиентов'],
            ],
        ],
        [
            'title' => 'Услуги',
            'slug' => 'services',
            'content' => '',
            'excerpt' => '',
            'preview' => 'services_hero.webp',
            'detail' => 'services_intro.webp',
            'properties' => [
                ['value' => 'Консультация', 'key' => 'Обсуждаем задачу и выясняем требования'],
                ['value' => 'Дизайн', 'key' => 'Разрабатываем концепцию и визуализацию'],
                ['value' => 'Согласование', 'key' => 'Утверждаем чертёж и смету'],
                ['value' => 'Производство', 'key' => 'Изготавливаем в собственном цехе'],
                ['value' => 'Монтаж', 'key' => 'Устанавливаем и сдаём объект'],
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->pages as $pageData) {
            $properties = is_array($pageData['properties'])
                ? json_encode($pageData['properties'])
                : $pageData['properties'];
            $detail = Attachment::where('original_name', $pageData['detail'])->first();
            $preview = Attachment::where('original_name', $pageData['preview'])->first();
            $page = Page::create([
                'title' => $pageData['title'],
                'slug' => $pageData['slug'],
                'excerpt' => $pageData['excerpt'],
                'content' => $pageData['content'],
                'preview_id' => $preview->id,
                'detail_id' => $detail->id,
                'properties' => $properties,
            ]);
        }
    }
}

```

### database/seeders/PortfolioProductSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}

```

### database/seeders/PortfolioSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class PortfolioSeeder extends Seeder
{
    protected array $items = [

        [
            'title' => 'Оформление фасада гипермаркета «Самара-Сити»',
            'image' => 'samara-city-main.webp',
            'excerpt' => 'Комплексное обновление фасадной вывески и входной группы крупнейшего гипермаркета Самары.',
            'content' => 'samara-city.md',
            'client' => 'Самара-Сити',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование', 'Обшивка фасадов'],
            'products' => ['Объемные буквы с фронтальным свечением', 'Композитный короб с инкрустацией'],
            'images' => [
                'samara-city-1.webp',
                'samara-city-2.webp',
                'samara-city-3.webp',
                'samara-city-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '15.03.2019',
            'budget' => 450000,
            'address' => 'ул. Ново-Садовая, 160',
            'properties' => [
                'Количество объектов' => '1 здание',
                'Срок выполнения' => '3 недели',
                'Материал лицевой' => 'Акрил 5 мм',
                'Борта' => 'Композит 4 мм',
                'Подсветка' => 'LED 2835, 6000K',
                'Гарантия' => '2 года',
            ],
        ],
        [
            'title' => 'Неоновая вывеска и интерьерное оформление бутика «Стиль+»',
            'image' => 'styleplus-main.webp',
            'excerpt' => 'Разработка и монтаж неоновой вывески, интерьерных световых панелей и навигации для модного бутика.',
            'content' => 'styleplus.md',
            'client' => 'Стиль+',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Винтажные световые буквы'],
            'images' => [
                'styleplus-main.webp',
                'styleplus-1.webp',
                'styleplus-2.webp',
                'styleplus-3.webp',
                'styleplus-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '22.08.2020',
            'budget' => 180000,
            'address' => 'ул. Ленинградская, 42',
            'properties' => [
                'Срок выполнения' => '10 дней',
                'Тип неона' => 'Гибкий неон',
                'Цвет свечения' => 'Розовый',
                'Мощность' => '120 Вт',
            ],
        ],
        [
            'title' => 'Яркое фасадное и интерьерное оформление магазина «Мир детства»',
            'image' => 'mirdetstva-main.webp',
            'excerpt' => 'Производство и монтаж объемных букв с пиксельной подсветкой, световых коробов и интерьерной навигации для магазина игрушек.',
            'content' => 'mirdetstva.md',
            'client' => 'Мир детства',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Объемные буквы с пиксельной подсветкой', 'Фигурный световой короб'],
            'images' => [
                'mirdetstva-main.webp',
                'mirdetstva-1.webp',
                'mirdetstva-2.webp',
                'mirdetstva-3.webp',
                'mirdetstva-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '10.12.2021',
            'budget' => 320000,
            'address' => 'пр. Кирова, 255',
            'properties' => [
                'Количество объектов' => '5 элементов',
                'Срок выполнения' => '2 недели',
                'Режим подсветки' => 'Динамический',
                'Пульт управления' => 'В комплекте',
            ],
        ],
        [
            'title' => 'Неоновая вывеска и винтажные световые буквы для бара «Креатив»',
            'image' => 'kreativ-main.webp',
            'excerpt' => 'Создание яркого ночного образа бара с неоновой вывеской, ретро-буквами и интерьерной подсветкой.',
            'content' => 'kreativ.md',
            'client' => 'Креатив',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Винтажные световые буквы'],
            'images' => [
                'kreativ-main.webp',
                'kreativ-1.webp',
                'kreativ-2.webp',
                'kreativ-3.webp',
                'kreativ-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '05.06.2022',
            'budget' => 250000,
            'address' => 'ул. Молодогвардейская, 67',
            'properties' => [
                'Стиль' => 'Винтаж',
                'Материал' => 'Латунь, акрил',
                'Цветовая температура' => '2700K',
                'Диммирование' => 'Есть',
            ],
        ],
        [
            'title' => 'Фасад ресторана «Русская трапеза» с контражурными объемными буквами',
            'image' => 'russkaya-trapeza-main.webp',
            'excerpt' => 'Оформление фасада ресторана с объемными буквами с контражурной подсветкой и декоративными элементами.',
            'content' => 'russkaya-trapeza.md',
            'client' => 'Русская трапеза',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Объемные буквы с контражурной подсветкой'],
            'images' => [
                'russkaya-trapeza-main.webp',
                'russkaya-trapeza-1.webp',
                'russkaya-trapeza-2.webp',
                'russkaya-trapeza-3.webp',
                'russkaya-trapeza-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '18.09.2022',
            'budget' => 550000,
            'address' => 'наб. Волги, 15',
            'properties' => [
                'Стиль' => 'Русский классический',
                'Материал' => 'Нержавейка, акрил',
                'Размер букв' => '1200 мм',
                'Количество' => '12 букв',
                'Крепление' => 'Фрезерованные шпильки',
            ],
        ],
        [
            'title' => 'Премиальное фасадное оформление автосалона «АвтоЛюкс»',
            'image' => 'autolux-main.webp',
            'excerpt' => 'Цельносветовые короба и композитная обшивка фасада для автосалона премиум-класса.',
            'content' => 'autolux.md',
            'client' => 'АвтоЛюкс',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Обшивка фасадов', 'Сварочные работы'],
            'products' => ['Цельносветовой короб', 'Композитный короб с инкрустацией'],
            'images' => [
                'autolux-main.webp',
                'autolux-1.webp',
                'autolux-2.webp',
                'autolux-3.webp',
                'autolux-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '03.11.2020',
            'budget' => 890000,
            'address' => 'Московское шоссе, 18 км',
            'properties' => [
                'Площадь остекления' => '120 м²',
                'Материал обшивки' => 'Алюкобонд',
                'Толщина композита' => '4 мм',
                'Количество световых коробов' => '3 шт',
                'Общая мощность' => '2.5 кВт',
            ],
        ],
        [
            'title' => 'Объёмные буквы с контражурной подсветкой для автосервиса «ТехноСервис»',
            'image' => 'tehnoservice-main.webp',
            'excerpt' => 'Изготовление и монтаж объёмных букв с контражурной подсветкой и светового короба для фасада автомастерской.',
            'content' => 'tehnoservice.md',
            'client' => 'ТехноСервис',
            'services' => ['Изготовление вывесок', 'Монтажные работы'],
            'products' => ['Объемные буквы с контражурной подсветкой', 'Цельносветовой короб'],
            'images' => [
                'tehnoservice-main.webp',
                'tehnoservice-1.webp',
                'tehnoservice-2.webp',
                'tehnoservice-3.webp',
                'tehnoservice-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '12.02.2023',
            'budget' => 210000,
            'address' => 'ул. Авроры, 150',
            'properties' => [
                'Материал' => 'Сталь, акрил',
                'Защита' => 'Антивандальная',
                'Цвет' => 'Черный матовый',
                'Подсветка' => 'LED 6500K',
            ],
        ],
        [
            'title' => 'Световые короба и интерьерная навигация для медцентра «Здоровье семьи»',
            'image' => 'zdorovye-main.webp',
            'excerpt' => 'Комплексное оформление фасада и интерьера медицинского центра: световые короба, навигационные таблички и информационные стенды.',
            'content' => 'zdorovye.md',
            'client' => 'Здоровье семьи',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Интерьерная печать', 'Плоттерная резка'],
            'products' => ['Короб с фронтальной подсветкой', 'Плоские буквы без подсветки'],
            'images' => [
                'zdorovye-main.webp',
                'zdorovye-1.webp',
                'zdorovye-2.webp',
                'zdorovye-3.webp',
                'zdorovye-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '07.04.2021',
            'budget' => 380000,
            'address' => 'ул. Советской Армии, 210',
            'properties' => [
                'Количество табличек' => '45 шт',
                'Материал' => 'ПВХ, акрил',
                'Способ нанесения' => 'УФ-печать',
                'Навигация' => 'Тактильная',
                'Стенды' => '5 шт',
            ],
        ],
        [
            'title' => 'Объёмные буквы с фронтальным свечением и акрилайты для стоматологии «Белоснежка»',
            'image' => 'belosnezhka-main.webp',
            'excerpt' => 'Изготовление вывески из объёмных букв с белой фронтальной подсветкой и декоративных акрилайтов для интерьера стоматологической клиники.',
            'content' => 'belosnezhka.md',
            'client' => 'Белоснежка',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Фрезеровка', 'Лазерная резка'],
            'products' => ['Объемные буквы с фронтальным свечением'],
            'images' => [
                'belosnezhka-main.webp',
                'belosnezhka-1.webp',
                'belosnezhka-2.webp',
                'belosnezhka-3.webp',
                'belosnezhka-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '19.05.2022',
            'budget' => 195000,
            'address' => 'ул. Победы, 84',
            'properties' => [
                'Материал' => 'Акрил белый',
                'Толщина' => '10 мм',
                'Подсветка' => 'LED 4000K',
                'Крепление' => 'Сплит-система',
            ],
        ],
        [
            'title' => 'Комплексное оформление отделения банка «Волга-Кредит»',
            'image' => 'volgakredit-main.webp',
            'excerpt' => 'Полный цикл работ по оформлению банковского отделения: обшивка фасада композитом, монтаж объёмных букв с подсветкой и световых коробов.',
            'content' => 'volgakredit.md',
            'client' => 'Волга-Кредит',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Обшивка фасадов', 'Сварочные работы'],
            'products' => ['Объемные буквы с фронтальным свечением', 'Композитный короб с инкрустацией', 'Цельносветовой короб'],
            'images' => [
                'volgakredit-main.webp',
                'volgakredit-1.webp',
                'volgakredit-2.webp',
                'volgakredit-3.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '28.07.2019',
            'budget' => 750000,
            'address' => 'ул. Куйбышева, 95',
            'properties' => [
                'Площадь фасада' => '200 м²',
                'Материал' => 'Композит 3 мм',
                'Брендбук' => 'Соблюден',
                'Сроки' => '4 недели',
                'Гарантия' => '3 года',
            ],
        ],
        [
            'title' => 'Динамическая вывеска и тканевые лайтбоксы для фитнес-клуба «Атлетик»',
            'image' => 'atletik-main.webp',
            'excerpt' => 'Объёмные буквы с динамической подсветкой, крупноформатные тканевые лайтбоксы и интерьерные световые панели для фитнес-клуба.',
            'content' => 'atletik.md',
            'client' => 'Атлетик',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'УФ-печать', 'Интерьерная печать'],
            'products' => ['Объемные буквы с динамической подсветкой', 'Цельносветовой короб'],
            'images' => [
                'atletik-main.webp',
                'atletik-1.webp',
                'atletik-2.webp',
                'atletik-3.webp',
                'atletik-4.webp',
                'atletik-5.webp',
                'atletik-6.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '14.09.2023',
            'budget' => 680000,
            'address' => 'ул. Дачная, 24',
            'properties' => [
                'Режимы подсветки' => '8 программ',
                'Пульт ДУ' => 'В комплекте',
                'Материал коробов' => 'Алюминий',
                'Ткань' => 'Баннерная сетка',
                'Яркость' => '3000 Люмен',
            ],
        ],
        [
            'title' => 'Неоновая вывеска и тонкие световые панели для студии маникюра «Красота ногтей»',
            'image' => 'krasota-main.webp',
            'excerpt' => 'Индивидуальная неоновая вывеска, настенные световые панели Crystal и декоративные акрилайты для beauty-студии.',
            'content' => 'krasota.md',
            'client' => 'Красота ногтей',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование', 'Фрезеровка'],
            'products' => ['Винтажные световые буквы', 'Плоские буквы без подсветки'],
            'images' => [
                'krasota-main.webp',
                'krasota-1.webp',
                'krasota-2.webp',
                'krasota-3.webp',
                'krasota-4.webp',
                'krasota-5.webp',
                'krasota-6.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '03.12.2023',
            'budget' => 145000,
            'address' => 'пр. Ленина, 3',
            'properties' => [
                'Стиль' => 'Минимализм',
                'Цвет неона' => 'Розовый кварц',
                'Материал панелей' => 'Оргстекло',
                'Мощность' => '80 Вт',
            ],
        ],
        [
            'title' => 'Пилон, объёмные буквы и информационные стенды для строительной компании «ДомСтрой»',
            'image' => 'domstroy-main.webp',
            'excerpt' => 'Изготовление и монтаж отдельностоящего рекламного пилона, объёмных букв без подсветки и мобильных информационных стендов для офиса продаж.',
            'content' => 'domstroy.md',
            'client' => 'ДомСтрой',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Сварочные работы', 'Плоттерная резка'],
            'products' => ['Объемные буквы без подсветки', 'Панель-кронштейн двухсторонняя'],
            'images' => [
                'domstroy-main.webp',
                'domstroy-1.webp',
                'domstroy-2.webp',
                'domstroy-3.webp',
                'domstroy-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '21.10.2020',
            'budget' => 420000,
            'address' => 'ул. Георгия Димитрова, 112',
            'properties' => [
                'Высота пилона' => '6 м',
                'Материал' => 'Металл, ПВХ',
                'Площадь стендов' => '12 м²',
                'Количество' => '8 шт',
            ],
        ],
        [
            'title' => 'Винтажные световые буквы и тканевые лайтбоксы для отеля «Комфорт»',
            'image' => 'komfort-main.webp',
            'excerpt' => 'Фасадные винтажные световые буквы в стиле ретро, тканевые лайтбоксы в холле и навигационные таблички для городского отеля.',
            'content' => 'komfort.md',
            'client' => 'Комфорт',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Интерьерная печать', 'УФ-печать'],
            'products' => ['Винтажные световые буквы', 'Цельносветовой короб'],
            'images' => [
                'komfort-main.webp',
                'komfort-1.webp',
                'komfort-2.webp',
                'komfort-3.webp',
                'komfort-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '08.02.2022',
            'budget' => 520000,
            'address' => 'ул. Гагарина, 67',
            'properties' => [
                'Стиль' => 'Ретро',
                'Материал' => 'Латунь, стекло',
                'Табличек' => '30 шт',
                'Режим работы' => 'Круглосуточно',
            ],
        ],
        [
            'title' => 'Цельносветовые буквы, лайтбоксы и POSM для турагентства «Путешествие мечты»',
            'image' => 'putmechty-main.webp',
            'excerpt' => 'Изготовление цельносветовых объёмных букв, оконных лайтбоксов и рекламных POSM-материалов из оргстекла для офиса турагентства.',
            'content' => 'putmechty.md',
            'client' => 'Путешествие мечты',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'УФ-печать', 'Лазерная резка'],
            'products' => ['Цельносветовые буквы', 'Короб с фронтальной подсветкой'],
            'images' => [
                'putmechty-main.webp',
                'putmechty-1.webp',
                'putmechty-2.webp',
                'putmechty-3.webp',
                'putmechty-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '11.07.2021',
            'budget' => 280000,
            'address' => 'ул. Пушкина, 56',
            'properties' => [
                'Форматы' => 'A4, A3, A2',
                'Материал' => 'Оргстекло 3 мм',
                'Стойки' => 'В комплекте',
                'Тираж' => '50 шт',
            ],
        ],
        [
            'title' => 'Объёмные буквы с пиксельной подсветкой для школы «English Time»',
            'image' => 'englishtime-main.webp',
            'excerpt' => 'Яркие объёмные буквы с пиксельной LED-подсветкой на фасаде и настольные световые панели Тейбл тент для зоны ресепшн языковой школы.',
            'content' => 'englishtime.md',
            'client' => 'English Time',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Объемные буквы с пиксельной подсветкой', 'Плоские буквы без подсветки'],
            'images' => [
                'englishtime-main.webp',
                'englishtime-1.webp',
                'englishtime-2.webp',
                'englishtime-3.webp',
                'englishtime-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '25.04.2023',
            'budget' => 230000,
            'address' => 'ул. Стара-Загора, 167',
            'properties' => [
                'Режимы' => '5 программ',
                'Управление' => 'С телефона',
                'Яркость' => 'Регулируемая',
                'Цвета' => 'RGB',
            ],
        ],
        [
            'title' => 'Фигурный световой короб для детского сада «Солнышко»',
            'image' => 'solnyshko-main.webp',
            'excerpt' => 'Фигурный световой короб в форме солнца, яркие объёмные буквы и навигационные таблички для частного детского сада.',
            'content' => 'solnyshko.md',
            'client' => 'Солнышко',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Фрезеровка', 'Плоттерная резка'],
            'products' => ['Фигурный световой короб', 'Объемные буквы с фронтальным свечением'],
            'images' => [
                'solnyshko-main.webp',
                'solnyshko-1.webp',
                'solnyshko-2.webp',
                'solnyshko-3.webp',
                'solnyshko-4.webp',
                'solnyshko-5.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '16.08.2022',
            'budget' => 195000,
            'address' => 'ул. Юбилейная, 34',
            'properties' => [
                'Диаметр' => '1.5 м',
                'Материал' => 'Акрил цветной',
                'Цвета' => 'Желтый, оранжевый',
                'Безопасность' => '12V',
            ],
        ],
        [
            'title' => 'Плоские буквы с контражурной подсветкой для страховой компании «Капитал-Полис»',
            'image' => 'kapitalpolis-main.webp',
            'excerpt' => 'Строгие плоские буквы с контражурной подсветкой, двусторонняя панель-кронштейн и POSM-изделия для офиса страховой компании.',
            'content' => 'kapitalpolis.md',
            'client' => 'Капитал-Полис',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'УФ-печать'],
            'products' => ['Плоские буквы с контражурной подсветкой', 'Панель-кронштейн двухсторонняя'],
            'images' => [
                'kapitalpolis-main.webp',
                'kapitalpolis-1.webp',
                'kapitalpolis-2.webp',
                'kapitalpolis-3.webp',
                'kapitalpolis-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '30.01.2024',
            'budget' => 315000,
            'address' => 'ул. Мичурина, 78',
            'properties' => [
                'Стиль' => 'Деловой',
                'Цвет' => 'Синий металлик',
                'Подсветка' => 'LED 5000K',
                'Гарантия' => '5 лет',
                'Антивандальная' => 'Да',
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->items as $index => $item) {
            $attachment = Attachment::where('original_name', $item['image'])->first();
            $attachments = [];

            foreach ($item['images'] as $image) {
                $file = Attachment::where('original_name', $image)->first();
                if ($file) {
                    array_push($attachments, $file);
                }
            }

            if (! $attachment) {
                $this->command->warn("⚠️ Attachment {$item['image']} не найден");

                continue;
            }

            $markdownPath = storage_path('app/public/seed/markdown/'.$item['content']);

            if (! file_exists($markdownPath)) {
                $this->command->warn("⚠️ Markdown файл {$item['content']} не найден по пути: {$markdownPath}");

                continue;
            }

            $client = Client::where('title', 'like', '%'.$item['client'].'%')->first();

            if (! $client) {
                $this->command->warn("⚠️ Клиент не найден: {$item['client']}");

                continue;
            }

            // Чтение содержимого Markdown
            $content = file_get_contents($markdownPath);

            // Преобразуем дату из формата дд.мм.гггг в объект Carbon
            $completedAt = Carbon::createFromFormat('d.m.Y', $item['completed_at']);

            $portfolio = Portfolio::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['excerpt'],
                'content' => $content,
                'preview_id' => $attachment->id,
                'detail_id' => $attachment->id,
                'sort' => $index + 1,
                'client_id' => $client->id,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
                // Новые поля
                'city' => $item['city'],
                'completed_at' => $completedAt,
                'budget' => $item['budget'],
                'address' => $item['address'],
                'properties' => json_encode($item['properties'], JSON_UNESCAPED_UNICODE),
            ]);

            // Прикрепляем изображения
            foreach ($attachments as $file) {
                $portfolio->attachments()->syncWithoutDetaching($file->id);
            }

            $this->command->info('✓ Прикреплено изображений: '.count($attachments));

            // Прикрепляем услуги (многие-ко-многим)
            if (isset($item['services'])) {
                foreach ($item['services'] as $serviceTitle) {
                    $service = Service::where('title', $serviceTitle)->first();
                    if ($service) {
                        $portfolio->services()->syncWithoutDetaching($service->id);
                        $this->command->info("  └─ Добавлена услуга: {$serviceTitle}");
                    } else {
                        $this->command->warn("  └─ ⚠️ Услуга не найдена: {$serviceTitle}");
                    }
                }
            }

            // Прикрепляем продукцию (многие-ко-многим)
            if (isset($item['products'])) {
                foreach ($item['products'] as $productTitle) {
                    $product = Product::where('title', $productTitle)->first();
                    if ($product) {
                        $portfolio->products()->syncWithoutDetaching($product->id);
                        $this->command->info("  └─ Добавлен продукт: {$productTitle}");
                    } else {
                        $this->command->warn("  └─ ⚠️ Продукт не найден: {$productTitle}");
                    }
                }
            }

            $this->command->info("✓ Создан проект портфолио: {$item['title']}");
            $this->command->info('---');
        }

        $this->command->info('🎉 Все проекты портфолио успешно созданы!');
    }
}

```

### database/seeders/PortfolioServiceSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}

```

### database/seeders/ProductCategoryFilterSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductCategoryFilter;
use App\Models\ProductCategoryFilterValue;
use Illuminate\Database\Seeder;

class ProductCategoryFilterSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Объёмные буквы' => [
                'backlight' => ['Без подсветки', 'Фронтальная', 'Контражурная', 'Двойная', 'Цельносветовая'],
                'material' => ['Акрил', 'Композит', 'Металл'],
                'mounting' => ['Улица', 'Интерьер'],
            ],
            'Плоские буквы' => [
                'backlight' => ['Без подсветки', 'Контражурная'],
                'material' => ['ПВХ', 'Акрил', 'Металл'],
            ],
            'Световые короба' => [
                'light_type' => ['Фронтальная', 'Цельносветовая'],
                'body' => ['Акрил', 'Композит'],
                'shape' => ['Прямоугольный', 'Фигурный'],
            ],
            'Панель-кронштейны' => [
                'sides' => ['Односторонний', 'Двухсторонний'],
                'body' => ['Стандарт', 'Композит «на прорез»'],
            ],
            'Интерьерные световые панели' => [
                'format' => ['A4', 'A3', 'A2'],
                'mounting' => ['Настольный', 'Настенный', 'Подвесной'],
            ],
            'Современные вывески' => [
                'technology' => ['Текстиль', 'Акрил', 'Неон'],
                'place' => ['Интерьер', 'Фасад'],
            ],
            'Навигация' => [
                'type' => ['Стенд', 'Табличка'],
                'material' => ['Пластик', 'Металл', 'Композит'],
            ],
            'POSM и Полиграфия' => [
                'product_type' => ['POSM', 'Полиграфия'],
                'material' => ['Пластик', 'Бумага', 'Картон'],
            ],
        ];

        foreach ($map as $categoryTitle => $filters) {
            $category = ProductCategory::where('title', $categoryTitle)->first();

            foreach ($filters as $code => $values) {
                $filter = ProductCategoryFilter::create([
                    'category_id' => $category->id,
                    'code' => $code,
                    'title' => mb_ucfirst(str_replace('_', ' ', $code)),
                    'type' => 'checkbox',
                    'active' => true,
                ]);

                foreach ($values as $sort => $value) {
                    ProductCategoryFilterValue::create([
                        'filter_id' => $filter->id,
                        'value' => $value,
                        'sort' => $sort,
                        'active' => true,
                    ]);
                }
            }
        }
    }
}

```

### database/seeders/ProductCategoryFilterValueSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategoryFilterValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}

```

### database/seeders/ProductCategorySeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;
use Orchid\Attachment\Models\Attachment;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Объемные буквы',
                'excerpt' => 'Изготовление объемных букв с подсветкой и без — для фасадов и интерьеров.',
                'content' => <<<'HTML'
                    <p>Вывеска с объемными буквами – самый распространенный и эффективный вид наружной рекламы. Яркие надписи хорошо видны с большого расстояния, легко привлекают внимание и преображают облик зданий. Такие изделия могут устанавливаться на любой поверхности, а широкий выбор материалов делает их доступными для любого бюджета. Наша компания готова создать презентабельную вывеску для любого коммерческого, государственного или общественного объекта с учетом всех индивидуальных пожеланий заказчика и требований законодательства.</p>
                    <p>Объемные буквы позволяют стильно оформлять входные группы торговых точек, развлекательных центров, банков, аптек, салонов красоты, офисов, клиник, других учреждений и организаций. Также их можно устанавливать на фасадах и крышах зданий. Вариативность дизайна, размеров и конфигураций позволяет использовать светящиеся буквы и для декоративного оформления домашних интерьеров, и многих других дизайнерских задач.</p>
                    <p>Изготовление объемных букв с подсветкой выполняется компанией Нарратив по индивидуальным проектам. В процессе их производства используем прочные и надежные каркасы из стали или алюминиевого профиля. Лицевая сторона выполняется из ПВХ, оргстекла или акрила. Эффектное свечение букв обеспечивает светодиодная или неоновая подсветка, а окрашивание в необходимый цвет выполняется с помощью самоклеющихся пленок.</p>
                    <p>Конструкция объемных букв может иметь любые габариты и форму. Собственное производство позволяет нам создавать большие и компактные надписи на русском или иностранном языке с использованием стандартных и оригинальных шрифтов. Расцветка подбирается с учетом фирменного стиля бренда и включает все оттенки палитры RAL. Для получения нужного визуального эффекта предлагаем различные варианты подсветки – торцевая, лицевая, контражурная.</p>
                    <p>Монтаж световых букв выполняется выездной бригадой с полным соблюдением норм безопасности. Доставляем готовую конструкцию на объект, производим ее сборку и крепление, подключаем к электропитанию. Для работ на высоте привлекаем промышленных альпинистов и спецтехнику. При необходимости помогаем согласовать монтаж вывески в государственных органах.</p>
                    <p>Объемные буквы из жидкого акрила – инновация в мире наружной рекламы. Такие изделия производятся методом литья и имеют цельную конструкцию без швов. В качестве несущей подложки используется алюминиевый профиль. Уникальные характеристики акрила наделяют готовые буквы стойкость к перепадам температур и атмосферным воздействиям, большой прочностью и большим сроком службы (до 10 лет). При этом они выглядят презентабельно и создают более яркое свечение, чем традиционные модели с пленочным покрытием.</p>
                    <p>Цена световых букв зависит от специфики конкретного проекта. Основными параметрами, влияющими на итоговую стоимость конструкции, являются:</p>
                    <ul>
                        <li>используемые материалы;</li>
                        <li>размеры и сложность формы;</li>
                        <li>тип подсветки;</li>
                        <li>способ крепления;</li>
                        <li>место установки.</li>
                    </ul>                
                    HTML,
                'sort' => 1,
                'preview' => 'obemnye-bukvy_intro.webp',
                'detail' => 'obemnye-bukvy_hero.webp',
            ],
            [
                'title' => 'Плоские буквы',
                'excerpt' => 'Лаконичные и бюджетные плоские буквы для фасадной и интерьерной рекламы.',
                'content' => <<<'HTML'
                    <p>Плоские буквы – классическое решение для наружной и интерьерной рекламы, которое не теряет своей актуальности благодаря простоте исполнения, доступной стоимости и четкой читаемости. В отличие от объемных аналогов, такие конструкции имеют минимальную толщину и представляют собой силуэтные элементы, вырезанные из листовых материалов. Они идеально подходят для создания информационных табличек, режимных надписей, указателей и логотипов на фасадах зданий.</p>
                    
                    <p>Основное преимущество плоских букв – их универсальность и экономичность. Они могут использоваться как самостоятельный рекламный носитель или в составе комплексного оформления фасада вместе с объемными элементами. Благодаря небольшому весу, монтаж таких конструкций не требует усиленного крепления и может выполняться практически на любые поверхности – бетон, кирпич, сайдинг, стекло, сэндвич-панели.</p>
                    
                    <p>В производстве плоских букв мы используем качественные материалы, устойчивые к атмосферным воздействиям:</p>
                    <ul>
                        <li>Композитные панели (алюкобонд) – для премиального внешнего вида и долговечности;</li>
                        <li>ПВХ (Пластик) толщиной 3-10 мм – оптимальное соотношение цены и качества;</li>
                        <li>Акриловое стекло (оргстекло) – для создания эффекта прозрачности или цветного остекления;</li>
                        <li>Металл с порошковой окраской – для максимальной надежности и солидного внешнего вида.</li>
                    </ul>
                    
                    <p>Поверхность букв может быть окрашена в любой цвет по каталогу RAL, покрыта самоклеящейся пленкой с полноцветной печатью или иметь фактуру под дерево, камень, металл. Возможно нанесение защитного лакового покрытия для дополнительной стойкости к истиранию и выцветанию.</p>
                    
                    <p>Контражурная подсветка – вариант, при котором плоские буквы монтируются на небольшом расстоянии от стены, а светодиодная лента устанавливается за ними. Это создает эффект парящей надписи с мягким свечением по контуру. Такой прием особенно эффектно смотрится в вечернее время и позволяет выделить вывеску среди конкурентов.</p>
                    
                    <p>Плоские буквы без подсветки – классическое решение для помещений и фасадов, где не требуется яркая световая реклама. Они отлично подходят для строгих офисных стилей, музейных экспозиций, исторических зданий, где использование светящихся элементов может быть ограничено архитектурными требованиями.</p>
                    
                    <p>Мы изготавливаем плоские буквы любой сложности – от простых геометрических форм до фигурных элементов с вырезами и сложной конфигурацией. Современное оборудование лазерной и фрезерной резки обеспечивает идеальную точность и чистоту краев без дополнительной обработки.</p>
                    HTML,
                'sort' => 2,
                'preview' => 'ploskie-bukvy_intro.webp',
                'detail' => 'ploskie-bukvy_hero.webp',
            ],
            [
                'title' => 'Световые короба',
                'excerpt' => 'Яркие и заметные световые короба (лайтбоксы) для наружной рекламы и оформления фасадов.',
                'content' => <<<'HTML'
                    <p>Световые короба (лайтбоксы) – один из самых популярных видов наружной рекламы, представляющий собой объемную конструкцию с внутренней подсветкой. Лицевая поверхность короба выполняется из светорассеивающих материалов (молочный акрил, баннерная ткань), на которую наносится рекламное изображение. Внутри размещаются светодиодные модули, обеспечивающие равномерное яркое свечение по всей площади.</p>
                    
                    <p>Такие конструкции отлично работают в любое время суток: днем изображение воспринимается как обычный рекламный щит, а с наступлением темноты включается подсветка, превращая короб в яркий световой маяк. Лайтбоксы широко используются для оформления торговых центров, магазинов, аптек, ресторанов, автозаправочных станций и других коммерческих объектов.</p>
                    
                    <p>Фронтальная подсветка – классическая конструкция, где свет исходит только из лицевой части короба. Внутри короба равномерно распределяются светодиодные модули или используется подсветка по торцам (Edge-LED), что обеспечивает отсутствие затемненных участков и "эффекта сот". Такие короба отличаются максимальной яркостью и отлично читаются с дальнего расстояния.</p>
                    
                    <p>Цельносветовой короб – инновационное решение, при котором все поверхности короба (лицевая, боковые, иногда задняя) выполнены из светопрозрачных материалов. Благодаря особой конструкции светодиодной системы, свечение равномерно распределяется по всем граням, создавая эффект объемного светящегося объекта. Такие короба выглядят современно и привлекают внимание своей необычностью.</p>
                    
                    <p>Композитный с инкрустацией – вариант премиум-класса, где основной короб выполняется из композитных материалов (алюкобонд), а лицевая поверхность декорируется вставками из акрила, металла или других материалов с дополнительной подсветкой или без нее. Такие конструкции часто используются для создания эксклюзивных вывесок премиальных брендов, бутиков, ресторанов.</p>
                    
                    <p>Композитный "на прорез" – технология, при которой в композитной панели вырезаются элементы (буквы, логотип), а с обратной стороны устанавливается подсветка. Свет проникает через прорези, создавая четкое контурное свечение. Такие короба отличаются строгим, лаконичным дизайном и идеально подходят для оформления в современном минималистичном стиле.</p>
                    
                    <p>Фигурный световой короб может иметь любую произвольную форму – от простых геометрических фигур до сложных контуров, повторяющих очертания логотипа или персонажа. Изготовление таких конструкций требует более сложной технологии, но результат оправдывает затраты – вы получаете уникальный рекламный носитель, максимально соответствующий вашему фирменному стилю.</p>
                    
                    <p>При производстве световых коробов мы используем качественные комплектующие: влагозащищенные светодиоды (IP65), алюминиевый профиль, устойчивые к УФ-излучению пленки. Это гарантирует долгий срок службы (до 7-10 лет) и сохранение яркости цветов даже при интенсивной эксплуатации на открытом воздухе.</p>
                    HTML,
                'sort' => 3,
                'preview' => 'svetovye-koroba_intro.webp',
                'detail' => 'svetovye-koroba_hero.webp',
            ],
            [
                'title' => 'Панель-кронштейны',
                'excerpt' => 'Функциональные и заметные панель-кронштейны для наружной рекламы и навигации.',
                'content' => <<<'HTML'
                    <p>Панель-кронштейны – это рекламные конструкции, которые монтируются перпендикулярно фасаду здания на специальных кронштейнах. Такое расположение обеспечивает отличную видимость как для пешеходов, движущихся вдоль здания, так и для водителей проезжающего транспорта. Панель-кронштейны широко используются для обозначения входов в магазины, аптеки, кафе, салоны красоты и другие заведения, расположенные на первых этажах зданий.</p>
                    
                    <p>Главное преимущество панель-кронштейнов – их двухстороннее исполнение. Информация наносится с обеих сторон конструкции, что позволяет видеть ее при движении в любом направлении. Это особенно актуально для оживленных улиц, где поток пешеходов и транспорта движется в обе стороны.</p>
                    
                    <p>Двухсторонние панель-кронштейны могут изготавливаться в различных вариантах:</p>
                    <ul>
                        <li>С плоскими панелями из композита или ПВХ – легкие, доступные по цене, подходят для большинства объектов;</li>
                        <li>Со световыми коробами – оснащаются внутренней подсветкой, работают круглосуточно;</li>
                        <li>С объемными буквами – премиальный вариант, сочетающий кронштейн и объемные световые элементы;</li>
                        <li>Комбинированные – используют различные материалы и технологии для создания уникального дизайна.</li>
                    </ul>
                    
                    <p>Двухсторонняя композитная панель-кронштейн "на прорез" – современное дизайнерское решение, при котором в композитной панели вырезаются буквы или элементы логотипа, а с обратной стороны устанавливается подсветка. Свет проникает через прорези, создавая четкое контурное свечение, видимое с обеих сторон. Такая конструкция выглядит стильно и технологично, привлекая внимание к вашему заведению.</p>
                    
                    <p>При производстве панель-кронштейнов мы учитываем все требования к безопасности и надежности. Крепления рассчитываются с запасом прочности с учетом ветровых нагрузок и веса конструкции. Используем качественные материалы, устойчивые к коррозии и атмосферным воздействиям: алюминий, нержавеющую сталь, композитные панели.</p>
                    
                    <p>Варианты исполнения панель-кронштейнов могут включать дополнительные элементы: декоративные вставки, часы, термометры, информационные табло. Возможно изготовление конструкций нестандартной формы – в виде стрелок, указателей, фирменных элементов. Размеры подбираются индивидуально в зависимости от архитектурных особенностей здания и требований заказчика.</p>
                    
                    <p>Монтаж панель-кронштейнов требует особого внимания к надежности крепления, так как конструкция испытывает повышенные ветровые нагрузки из-за своего выступающего положения. Наши специалисты профессионально выполняют установку с использованием анкерных систем соответствующей несущей способности, гарантируя безопасность и долговечность конструкции.</p>
                    HTML,
                'sort' => 4,
                'preview' => 'panel-kronshtejny_intro.webp',
                'detail' => 'panel-kronshtejny_hero.webp',
            ],
            [
                'title' => 'Интерьерные световые панели',
                'excerpt' => 'Стильные световые панели для оформления интерьеров торговых и офисных помещений.',
                'content' => <<<'HTML'
                    <p>Интерьерные световые панели – современное решение для оформления внутренних помещений. Они сочетают в себе функции рекламоносителя, элемента навигации и декоративного освещения. Такие панели широко используются в торговых центрах, магазинах, ресторанах, офисах, выставочных залах и других общественных пространствах.</p>
                    
                    <p>Тейбл тент (1/2 ст.) – компактные настольные световые панели, устанавливаемые на стойках ресепшн, прилавках, барных стойках или столах. Идеально подходят для меню, акционных предложений, информационных материалов. Двухстороннее исполнение позволяет размещать информацию с двух сторон, что удобно для посетителей, сидящих напротив. Подсветка привлекает внимание к размещенной информации и создает уютную атмосферу.</p>
                    
                    <p>Кристалайт Crystal – премиальная серия интерьерных световых панелей, отличающихся особой эстетикой. Панели имеют многослойную структуру с объемными элементами, создающими эффект кристальной глубины и сияния. Доступны в трех вариантах исполнения (S, M, L), отличающихся размерами и конфигурацией. Идеально подходят для размещения логотипов, бренд-зон, навигационных указателей в местах с высокими требованиями к дизайну.</p>
                    
                    <p>Crystal Round – серия круглых световых панелей с тем же эффектом кристального свечения. Круглая форма позволяет создавать мягкие, гармоничные композиции, хорошо вписывающиеся в современные интерьеры. Три типоразмера дают возможность комбинировать панели для создания уникальных световых инсталляций, акцентных стен, указателей.</p>
                    
                    <p>Frame – серия световых панелей в стиле минимализм с тонкой металлической рамкой. Панели имеют строгий, лаконичный дизайн и подходят для оформления офисов, медицинских центров, салонов красоты, где требуется сочетание функциональности и элегантности. Три варианта размеров позволяют подобрать оптимальное решение для любого помещения.</p>
                    
                    <p>Magnetic – инновационная серия панелей с магнитным креплением информационных вставок. Основой служит световая панель с равномерной подсветкой, на которую с помощью магнитов крепятся сменные элементы с информацией – логотипы, указатели, ценники, меню. Это позволяет быстро и без инструментов менять содержание панели, что особенно актуально для магазинов, кафе, выставочных стендов с часто обновляемой информацией.</p>
                    
                    <p>Все интерьерные световые панели производятся из качественных материалов с использованием энергоэффективных светодиодов. Толщина панелей минимальна (от 8 мм), что придает им изящный, современный вид. Равномерное свечение без темных пятен обеспечивается специальной светорассеивающей подложкой. Питание осуществляется от стандартной сети 220В или через USB (для компактных моделей).</p>
                    
                    <p>Мы предлагаем как готовые решения из указанных серий, так и изготовление панелей по индивидуальным проектам – с уникальными размерами, формой, цветом свечения, нанесением полноцветных изображений методом УФ-печати.</p>
                    HTML,
                'sort' => 5,
                'preview' => 'interernye-paneli_intro.webp',
                'detail' => 'interernye-paneli_hero.webp',
            ],
            [
                'title' => 'Современные вывески',
                'excerpt' => 'Трендовые решения для наружной и интерьерной рекламы: текстиль, акрил, неон.',
                'content' => <<<'HTML'
                    <p>Современные вывески – это направление, объединяющее актуальные тренды в дизайне и технологиях рекламы. Здесь нет места скучным стандартным решениям – только оригинальные идеи, необычные материалы и эффектные световые эффекты. Такие вывески идеально подходят для заведений, ориентированных на молодежную аудиторию, креативных пространств, шоурумов, кафе, баров, салонов красоты.</p>
                    
                    <p>Текстильные лайтбоксы – инновационный вид световых конструкций, где вместо жесткого акрила или пластика используется специальная светорассеивающая ткань, натянутая на алюминиевый профиль. Преимущества таких вывесок:</p>
                    <ul>
                        <li>Малый вес – легко монтируются даже на легкие конструкции;</li>
                        <li>Безупречно ровная поверхность без бликов;</li>
                        <li>Возможность создания любых форм, включая сложные криволинейные;</li>
                        <li>Простота замены изображения – достаточно сменить тканевый чехол;</li>
                        <li>Мягкое, равномерное свечение без "эффекта сот".</li>
                    </ul>
                    <p>Текстильные лайтбоксы отлично подходят для выставочных стендов, временных акций, интерьеров с требованием к частой смене рекламных материалов.</p>
                    
                    <p>Акрилайты – вывески из объемного акрила с боковой (торцевой) подсветкой. Технология заключается в том, что светодиоды устанавливаются по торцам акрилового элемента, и свет распространяется внутри материала, высвечивая гравировку или делая светящимися края буквы. Это создает эффект "ледяного" свечения – мягкого, загадочного, необычного. Акрилайты могут быть выполнены в виде букв, логотипов, абстрактных форм и особенно эффектно смотрятся в интерьерах с приглушенным освещением.</p>
                    
                    <p>Неоновые вывески – бессмертная классика, переживающая новое рождение. Современные неоновые вывески используют не стеклянные газонаполненные трубки, а гибкий неон – светодиодный шнур в ПВХ-оболочке. Это дает множество преимуществ:</p>
                    <ul>
                        <li>Безопасность – низкое напряжение, отсутствие хрупкого стекла;</li>
                        <li>Гибкость – можно создавать любые формы и даже объемные композиции;</li>
                        <li>Яркость и насыщенность цвета;</li>
                        <li>Долговечность – срок службы до 50 000 часов;</li>
                        <li>Простота монтажа и обслуживания.</li>
                    </ul>
                    <p>Неоновые вывески стали главным трендом в оформлении интерьеров кафе, баров, кофеен, магазинов одежды и косметики. Яркие светящиеся фразы, слоганы, рисунки создают неповторимую атмосферу и становятся любимым фоном для фото в социальных сетях.</p>
                    
                    <p>Комбинируя различные технологии, мы создаем уникальные вывески, которые точно не останутся незамеченными. Возможно сочетание неона с акрилайтами, текстильными элементами, объемными буквами. Добавление динамических режимов (мерцание, бегущие огни) делает вывеску еще более заметной и современной.</p>
                    
                    <p>Все материалы, используемые при производстве современных вывесок, сертифицированы и безопасны для использования внутри помещений. При изготовлении наружных конструкций применяются влагозащищенные компоненты, устойчивые к перепадам температур и ультрафиолету.</p>
                    HTML,
                'sort' => 6,
                'preview' => 'sovremennye-vyveski_intro.webp',
                'detail' => 'sovremennye-vyveski_hero.webp',
            ],
            [
                'title' => 'Навигация',
                'excerpt' => 'Понятная и эстетичная навигация для офисов, торговых центров и общественных пространств.',
                'content' => <<<'HTML'
                    <p>Навигация – важнейший элемент любого общественного пространства. От того, насколько понятно организованы указатели, зависит удобство посетителей и эффективность работы персонала. Профессионально разработанная система навигации помогает посетителям легко ориентироваться, находить нужные отделы, кабинеты, услуги, а также формирует положительный имидж компании или учреждения.</p>
                    
                    <p>Информационные стенды – универсальное решение для размещения справочной информации. Они могут быть:</p>
                    <ul>
                        <li>Настенные – компактные, не занимают полезную площадь;</li>
                        <li>Напольные (мобильные) – на устойчивой подставке, можно переставлять;</li>
                        <li>Подвесные – крепятся к потолку, хорошо видны издалека;</li>
                        <li>С вращающимся механизмом – для удобства просмотра с разных сторон.</li>
                    </ul>
                    <p>Стенды могут быть плоскостными (информация наносится непосредственно на поверхность) или кармашкового типа (со сменными вкладышами формата А4, А3, А5). Возможно оснащение стендов дополнительной подсветкой для лучшей видимости.</p>
                    
                    <p>Информационные таблички – компактные указатели для кабинетов, отделов, функциональных зон. Основные виды табличек:</p>
                    <ul>
                        <li>Кабинетные – с названием отдела, должностью, именем сотрудника;</li>
                        <li>Указатели направления – со стрелками и пиктограммами;</li>
                        <li>Режимные – с информацией о часах работы, правилах поведения;</li>
                        <li>Предписывающие и запрещающие – "вход", "выход", "посторонним вход воспрещен", "курить запрещено" и т.п.</li>
                    </ul>
                    
                    <p>Таблички изготавливаются из различных материалов: пластик (ПВХ, акрил), металл (латунь, нержавейка, алюминий), дерево, композит. Возможно нанесение информации методом УФ-печати, гравировки, нанесения пленки, литья. Для помещений с высокими требованиями к дизайну предлагаем таблички премиум-класса – с объемными элементами, подсветкой, использованием натурального дерева или камня.</p>
                    
                    <p>Комплексные системы навигации разрабатываются с учетом архитектурных особенностей помещения, фирменного стиля компании и потребностей посетителей. Мы создаем единую стилистику для всех элементов – от входной группы до табличек на дверях, используем единые шрифты, цветовые решения, пиктограммы. Это создает целостное, профессиональное впечатление и облегчает ориентирование.</p>
                    
                    <p>Особое внимание уделяем тактильной навигации для людей с ограниченными возможностями – таблички с шрифтом Брайля, контрастной окраской, тактильными указателями. Это не только требование законодательства для многих типов учреждений, но и показатель социальной ответственности бизнеса.</p>
                    
                    <p>Все навигационные элементы производятся на современном оборудовании с высокой точностью. Используем качественные материалы, устойчивые к истиранию, выцветанию, механическим повреждениям. При необходимости выполняем монтаж "под ключ" с учетом всех требований безопасности и эстетики.</p>
                    HTML,
                'sort' => 7,
                'preview' => 'navigaciya_intro.webp',
                'detail' => 'navigaciya_hero.webp',
            ],
            [
                'title' => 'POSM и Полиграфия',
                'excerpt' => 'Рекламные материалы для точек продаж и полиграфическая продукция любого формата.',
                'content' => <<<'HTML'
                    <p>POS-материалы (Point of Sales Materials) и полиграфия – важнейший инструмент маркетинга в местах продаж. Именно здесь, непосредственно перед совершением покупки, покупатель принимает окончательное решение. Качественные, заметные и информативные POSM помогают привлечь внимание к товару, выделить его среди конкурентов, проинформировать о свойствах и преимуществах, стимулировать импульсные покупки.</p>
                    
                    <p>Изделия из оргстекла/пластика – долговечные и эстетичные решения для оформления торговых залов:</p>
                    <ul>
                        <li>Ценникодержатели – настольные, навесные, на магнитах, для любых типов полок;</li>
                        <li>Воблеры – гибкие подвесные элементы, привлекающие внимание;</li>
                        <li>Шелфтокеры – удлинители полок с рекламным блоком;</li>
                        <li>Диспенсеры – для листовок, визиток, буклетов;</li>
                        <li>Стопперы – напольные фигуры и конструкции;</li>
                        <li>Подставки под товар – для выкладки в оптимальном ракурсе.</li>
                    </ul>
                    <p>Прозрачное оргстекло не перекрывает обзор товара, выглядит аккуратно и профессионально. Цветной акрил или пластик используется для создания ярких акцентов, соответствующих фирменному стилю бренда. Возможно нанесение логотипов, слоганов, УФ-печать непосредственно на материал.</p>
                    
                    <p>Печатная продукция – широкий ассортимент рекламных и информационных материалов:</p>
                    <ul>
                        <li>Листовки, флаеры, буклеты – классические форматы для раздачи и распространения;</li>
                        <li>Каталоги, брошюры – многостраничная продукция с подробным описанием товаров и услуг;</li>
                        <li>Плакаты, постеры – для оформления интерьеров, витрин, стендов;</li>
                        <li>Календари – настольные, настенные, карманные, квартальные;</li>
                        <li>Блокноты, ежедневники – сувенирная продукция с брендированием;</li>
                        <li>Открытки, приглашения – для специальных мероприятий и акций;</li>
                        <li>Папки, конверты, бланки – фирменная документация.</li>
                    </ul>
                    
                    <p>Мы работаем с любыми видами печати:</p>
                    <ul>
                        <li>Цифровая печать – для малых и средних тиражей, срочных заказов;</li>
                        <li>Офсетная печать – для больших тиражей с оптимальной себестоимостью;</li>
                        <li>Широкоформатная печать – для плакатов, баннеров, постеров;</li>
                        <li>УФ-печать – на жестких материалах (пластик, дерево, металл, стекло);</li>
                        <li>Тиснение, конгрев, ламинация, вырубка – постпечатная обработка для премиального вида.</li>
                    </ul>
                    
                    <p>При производстве POSM и полиграфии используем качественные расходные материалы: плотную бумагу и картон, износостойкие пленки, сертифицированные краски. Это гарантирует яркость и четкость изображения, стойкость к истиранию и выцветанию.</p>
                    
                    <p>Помогаем с разработкой дизайн-макетов, подбором оптимальных материалов и технологий печати. Работаем как с сетевыми ритейлерами, требующими стандартизированных решений для тысяч магазинов, так и с небольшими компаниями, которым нужен эксклюзивный дизайн малых форм.</p>
                    
                    <p>Сроки изготовления зависят от сложности заказа и тиража, но в большинстве случаев мы готовы выполнить работу оперативно, не теряя в качестве. Осуществляем доставку по Москве и отправку в регионы транспортными компаниями.</p>
                    HTML,
                'sort' => 8,
                'preview' => 'posm-poligrafiya_intro.webp',
                'detail' => 'posm-poligrafiya_hero.webp',
            ],
        ];

        foreach ($categories as $category) {
            $slug = SlugService::createSlug(ProductCategory::class, 'slug', $category['title']);
            $detail = Attachment::where('original_name', $category['detail'])->first();
            $preview = Attachment::where('original_name', $category['preview'])->first();
            ProductCategory::create([
                'title' => $category['title'],
                'excerpt' => $category['excerpt'],
                'content' => $category['content'],
                'sort' => $category['sort'],
                'detail_id' => $detail->id,
                'preview_id' => $preview->id,
                'slug' => $slug,
                'active' => true,
                'published_at' => now(),
            ]);
        }
    }
}

```

### database/seeders/ProductSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryFilterValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            /* -------------------------------------------------
     | 1. ОБЪЁМНЫЕ БУКВЫ
     -------------------------------------------------*/
            'Объёмные буквы' => [
                [
                    'title' => 'Объёмные буквы без подсветки',
                    'filters' => ['Без подсветки', 'Акрил', 'Интерьер'],
                    'excerpt' => 'Классические объёмные буквы без подсветки для интерьеров и фасадов, где не требуется свечение.',
                    'content' => <<<'HTML'
            <p>Объёмные буквы без подсветки – классическое решение для оформления фасадов и интерьеров, когда требуется солидный, респектабельный вид без световых эффектов. Такие конструкции идеально подходят для офисов, бизнес-центров, государственных учреждений, где строгий стиль важнее яркости.</p>
            <p>Изготавливаются из качественных материалов: лицевая часть – цветной акрил или ПВХ с покрытием пленкой, боковины – ПВХ или композит. Буквы имеют толщину 20–50 мм, что обеспечивает хорошую читаемость с разных ракурсов. Возможно крепление как непосредственно к стене, так и на специальных держателях для создания эффекта парения.</p>
            <p>Преимущества: доступная цена, долговечность (срок службы 5–7 лет), широкие возможности колористики (любые цвета RAL), устойчивость к выцветанию. Отлично сочетаются с другими элементами навигации и рекламы.</p>
            HTML,
                    'properties' => [
                        'thickness' => '20–50 мм',
                        'usage' => 'Интерьер / Фасад',
                        'service_life' => '5–7 лет',
                        'material' => 'Акрил / ПВХ / Композит',
                        'mounting' => 'Стеновое / На держателях',
                    ],
                    'preview' => 'obemnye-bukvy-bez-podsvetki_intro.webp',
                    'detail' => 'obemnye-bukvy-bez-podsvetki_hero.webp',
                ],
                [
                    'title' => 'Объёмные буквы с фронтальной подсветкой',
                    'filters' => ['Фронтальная', 'Акрил', 'Улица'],
                    'excerpt' => 'Яркие объёмные буквы с фронтальной светодиодной подсветкой для наружной рекламы.',
                    'content' => <<<'HTML'
            <p>Объёмные буквы с фронтальной подсветкой – самый популярный вид световых вывесок. Лицевая часть выполнена из светорассеивающего акрила, за которым установлены яркие LED-модули. Благодаря равномерному свечению буквы отлично видны в темное время суток, а днем выглядят как аккуратные объемные элементы.</p>
            <p>Технология: корпус из алюминиевого профиля или ПВХ, лицевая часть – молочный или цветной акрил, внутри – влагозащищенные светодиоды (IP65). Толщина 60–80 мм обеспечивает равномерное рассеивание света без "горячих точек". Возможно исполнение с разноцветным свечением (RGB) и динамическими режимами.</p>
            <p>Идеально подходят для магазинов, ресторанов, салонов красоты, аптек – любых заведений, которым нужно выделиться и привлекать клиентов 24/7.</p>
            HTML,
                    'properties' => [
                        'thickness' => '60–80 мм',
                        'light_type' => 'LED 12V / 24V',
                        'visibility' => 'Высокая (до 300 м)',
                        'material' => 'Акрил + Алюминий',
                        'protection' => 'IP65',
                    ],
                    'preview' => 'obemnye-bukvy-frontalnaya_intro.webp',
                    'detail' => 'obemnye-bukvy-frontalnaya_hero.webp',
                ],
                [
                    'title' => 'Объёмные буквы с контражурной подсветкой',
                    'filters' => ['Контражурная', 'Металл', 'Улица'],
                    'excerpt' => 'Эффектные буквы с контражурной подсветкой, создающей светящийся ореол вокруг конструкции.',
                    'content' => <<<'HTML'
            <p>Объёмные буквы с контражурной подсветкой (backlight) – премиальное решение для наружной рекламы. Светодиоды устанавливаются не внутри буквы, а сзади, создавая эффект свечения по контуру. Сама буква может быть выполнена из непрозрачных материалов (металл, композит), а световой ореол делает её визуально "парящей" на стене.</p>
            <p>Особенность технологии: буквы крепятся на расстоянии 80–120 мм от стены, за ними монтируется LED-лента. Свет отражается от фасада и создает мягкое свечение вокруг каждой буквы. Это выглядит очень стильно и современно, особенно в вечернее время.</p>
            <p>Рекомендуется для бутиков, ресторанов высокой кухни, салонов, отелей – мест, где важен имидж и статус.</p>
            HTML,
                    'properties' => [
                        'thickness' => '80–120 мм',
                        'effect' => 'Световой ореол',
                        'premium' => true,
                        'material' => 'Металл / Композит',
                        'light_color' => 'Белый / RGB',
                    ],
                    'preview' => 'obemnye-bukvy-kontrazhurnaya_intro.webp',
                    'detail' => 'obemnye-bukvy-kontrazhurnaya_hero.webp',
                ],
                [
                    'title' => 'Объёмные буквы с двойным свечением',
                    'filters' => ['Двойная', 'Акрил', 'Улица'],
                    'excerpt' => 'Максимально заметные буквы с подсветкой лицевой части и контражурным свечением одновременно.',
                    'content' => <<<'HTML'
            <p>Объёмные буквы с двойным свечением сочетают преимущества фронтальной и контражурной подсветки. Лицевая часть из акрила светится ярким прямым светом, а дополнительная подсветка сзади создает эффектный ореол. Такая конструкция обеспечивает максимальную видимость и выразительность в любое время суток.</p>
            <p>Конструкция: используется два независимых контура светодиодов – один внутри буквы (фронтальный), второй снаружи (контражурный). Буквы крепятся на расстоянии от стены для обеспечения задней подсветки. Возможно управление контурами раздельно или совместно, создавая различные световые сценарии.</p>
            <p>Идеальный выбор для ключевых объектов, где требуется максимальное привлечение внимания – головные офисы, флагманские магазины, крупные развлекательные центры.</p>
            HTML,
                    'properties' => [
                        'light_front' => true,
                        'light_back' => true,
                        'effect' => 'Максимальная выразительность',
                        'material' => 'Акрил + Алюминий',
                        'protection' => 'IP65',
                    ],
                    'preview' => 'obemnye-bukvy-dvojnoe_intro.webp',
                    'detail' => 'obemnye-bukvy-dvojnoe_hero.webp',
                ],
                [
                    'title' => 'Цельносветовые объёмные буквы',
                    'filters' => ['Цельносветовая', 'Акрил', 'Улица'],
                    'excerpt' => 'Инновационные буквы, где светится не только лицевая часть, но и все боковые грани.',
                    'content' => <<<'HTML'
            <p>Цельносветовые объёмные буквы (или буквы из жидкого акрила) – технология, при которой светится вся конструкция целиком. Буквы отливаются из специального акрила, обладающего светорассеивающими свойствами. LED-модули устанавливаются в основании, и свет равномерно распределяется по всему объему буквы, включая все грани.</p>
            <p>Преимущества: отсутствие видимых швов, максимальная яркость, эффект "светящегося кристалла", возможность создания тонких элементов (до 5 мм). Срок службы до 10 лет. Буквы выглядят как цельные светящиеся объекты, привлекая внимание своей необычностью.</p>
            <p>Используются для премиальных брендов, ночных клубов, кинотеатров, развлекательных центров.</p>
            HTML,
                    'properties' => [
                        'light_body' => true,
                        'visibility_night' => 'Максимальная',
                        'material' => 'Жидкий акрил',
                        'seamless' => true,
                        'service_life' => 'до 10 лет',
                    ],
                    'preview' => 'obemnye-bukvy-celnosvetovye_intro.webp',
                    'detail' => 'obemnye-bukvy-celnosvetovye_hero.webp',
                ],
                [
                    'title' => 'Ретро-буквы Edison',
                    'filters' => ['Фронтальная', 'Металл', 'Интерьер'],
                    'excerpt' => 'Стилизованные буквы под старину с лампами Эдисона для интерьеров в стиле лофт.',
                    'content' => <<<'HTML'
            <p>Ретро-буквы Edison – уникальное дизайнерское решение для создания атмосферы в стиле лофт, индастриал или винтаж. Вместо скрытых светодиодов используются декоративные лампы Эдисона на цоколе E27, которые являются одновременно источником света и элементом декора.</p>
            <p>Конструкция: металлический каркас, к которому крепятся патроны с лампами. Лампы могут располагаться внутри объемного контура буквы или снаружи, создавая индустриальный образ. Используются лампы с теплым свечением (2200-2700K) различной формы – груша, свеча, шар.</p>
            <p>Идеально подходят для баров, ресторанов, кофеен, барбершопов, фотостудий – мест с особой атмосферой и стилем.</p>
            HTML,
                    'properties' => [
                        'lamps' => 'Edison E27',
                        'style' => 'Loft / Retro / Industrial',
                        'lamp_type' => 'Теплый свет 2200K',
                        'material' => 'Металл',
                        'usage' => 'Интерьер',
                    ],
                    'preview' => 'obemnye-bukvy-edison_intro.webp',
                    'detail' => 'obemnye-bukvy-edison_hero.webp',
                ],
                [
                    'title' => 'Пиксельные буквы',
                    'filters' => ['Фронтальная', 'Акрил', 'Улица'],
                    'excerpt' => 'Современные буквы с пиксельным управлением для создания анимированных изображений.',
                    'content' => <<<'HTML'
            <p>Пиксельные объёмные буквы – высокотехнологичное решение для наружной рекламы. Каждая буква состоит из множества независимо управляемых пикселей (светодиодов), что позволяет создавать на поверхности буквы различные анимированные изображения, бегущие строки, переливы цветов.</p>
            <p>Технология: на лицевую поверхность буквы выведены адресные RGB-светодиоды (пиксели) с шагом от 12.5 до 50 мм. Контроллер управляет каждым пикселем индивидуально, создавая любые световые сценарии. Возможна синхронизация всех букв вывески для создания общего анимированного полотна.</p>
            <p>Максимальный эффект достигается в темное время суток. Идеально для ночных клубов, кинотеатров, торговых центров, развлекательных комплексов.</p>
            HTML,
                    'properties' => [
                        'light_control' => 'Пиксельный (адресный)',
                        'effects' => 'Анимация, графика, видео',
                        'pixel_pitch' => '12.5–50 мм',
                        'material' => 'Акрил + Композит',
                    ],
                    'preview' => 'obemnye-bukvy-pikselnye_intro.webp',
                    'detail' => 'obemnye-bukvy-pikselnye_hero.webp',
                ],
                [
                    'title' => 'Динамические объёмные буквы',
                    'filters' => ['Фронтальная', 'Акрил', 'Улица'],
                    'excerpt' => 'Буквы с динамическими световыми эффектами: переливы, бегущие огни, смена цвета.',
                    'content' => <<<'HTML'
            <p>Динамические объёмные буквы – это эволюция классических световых вывесок. В них используются RGB-светодиоды и контроллеры, позволяющие программировать различные световые сценарии: плавное переливание цветов, бегущие огни, мерцание, стробоскопические эффекты.</p>
            <p>Конструкция аналогична стандартным объемным буквам с фронтальной подсветкой, но вместо монохромных LED используются полноцветные RGB-модули. Контроллер может хранить несколько программ, переключаемых по расписанию или вручную.</p>
            <p>Такие вывески привлекают повышенное внимание благодаря движению и смене цветов. Особенно эффективны в местах с высокой концентрацией людей и конкурирующих вывесок.</p>
            HTML,
                    'properties' => [
                        'effects' => 'Бегущие огни, переливы, смена цвета',
                        'control' => 'Программируемый контроллер',
                        'colors' => 'RGB (16 млн цветов)',
                        'modes' => '5+ режимов',
                    ],
                    'preview' => 'obemnye-bukvy-dinamicheskie_intro.webp',
                    'detail' => 'obemnye-bukvy-dinamicheskie_hero.webp',
                ],
            ],

            /* -------------------------------------------------
     | 2. ПЛОСКИЕ БУКВЫ
     -------------------------------------------------*/
            'Плоские буквы' => [
                [
                    'title' => 'Плоские буквы без подсветки',
                    'filters' => ['Без подсветки', 'ПВХ'],
                    'excerpt' => 'Лаконичные и бюджетные плоские буквы для интерьерной навигации и фасадов.',
                    'content' => <<<'HTML'
            <p>Плоские буквы без подсветки – простое и экономичное решение для информационных табличек, указателей, навигации. Изготавливаются из листовых материалов (ПВХ, композит, акрил) толщиной 3-10 мм путем фрезеровки или лазерной резки.</p>
            <p>Края букв могут быть окрашены в цвет лицевой поверхности или контрастный цвет. Возможно покрытие пленками с полноцветной печатью, имитацией дерева, металла, камня. Крепление осуществляется на клей, двухсторонний скотч или механическим способом.</p>
            <p>Идеально подходят для офисов, режимных табличек, номеров кабинетов, указателей внутри помещений. Срок службы – 5-7 лет без потери внешнего вида.</p>
            HTML,
                    'properties' => [
                        'thickness' => '3–10 мм',
                        'usage' => 'Интерьер / Фасад',
                        'material' => 'ПВХ / Композит / Акрил',
                        'mounting' => 'Клей / Скотч / Механический',
                    ],
                    'preview' => 'ploskie-bukvy-bez-podsvetki_intro.webp',
                    'detail' => 'ploskie-bukvy-bez-podsvetki_hero.webp',
                ],
                [
                    'title' => 'Плоские буквы с контражурной подсветкой',
                    'filters' => ['Контражурная', 'Акрил'],
                    'excerpt' => 'Плоские буквы с эффектом парения благодаря контражурной подсветке.',
                    'content' => <<<'HTML'
            <p>Плоские буквы с контражурной подсветкой – современное решение для создания эффекта "парящей" надписи. Буквы крепятся на расстоянии 20-40 мм от стены, а за ними монтируется LED-лента. Свет очерчивает контур букв, создавая мягкое свечение.</p>
            <p>Буквы могут быть выполнены из непрозрачных материалов (композит, металл) или цветного акрила. В дневное время они выглядят как обычные плоские буквы, а с наступлением темноты включается подсветка, преображая вывеску.</p>
            <p>Отлично подходит для ресторанов, отелей, салонов красоты, где требуется стильный, но не кричащий световой эффект.</p>
            HTML,
                    'properties' => [
                        'light_effect' => 'Ореол по контуру',
                        'usage' => 'Интерьер / Фасад',
                        'material' => 'Композит / Металл / Акрил',
                        'distance' => '20–40 мм от стены',
                    ],
                    'preview' => 'ploskie-bukvy-kontrazhurnye_intro.webp',
                    'detail' => 'ploskie-bukvy-kontrazhurnye_hero.webp',
                ],
            ],

            /* -------------------------------------------------
     | 3. СВЕТОВЫЕ КОРОБА
     -------------------------------------------------*/
            'Световые короба' => [
                [
                    'title' => 'Световой короб с фронтальной подсветкой',
                    'filters' => ['Фронтальная', 'Акрил', 'Прямоугольный'],
                    'excerpt' => 'Классический лайтбокс с равномерной фронтальной подсветкой для наружной рекламы.',
                    'content' => <<<'HTML'
            <p>Световой короб с фронтальной подсветкой (лайтбокс) – самый популярный вид наружной рекламы. Конструкция представляет собой объемный короб (глубина 80-200 мм) с лицевой поверхностью из светорассеивающего акрила или баннерной ткани, на которую наносится рекламное изображение.</p>
            <p>Внутри равномерно распределены LED-модули, обеспечивающие яркое свечение без затемненных участков. Используются влагозащищенные светодиоды (IP65) с ресурсом 50 000+ часов. Корпус выполняется из оцинкованной стали или алюминиевого профиля с порошковой окраской.</p>
            <p>Применяется для вывесок магазинов, аптек, АЗС, торговых центров. Отлично работает в любое время суток, привлекая внимание клиентов.</p>
            HTML,
                    'properties' => [
                        'light' => 'LED 12V / 24V',
                        'application' => 'Фасад / Крыша',
                        'depth' => '80–200 мм',
                        'material' => 'Акрил + Оцинкованная сталь',
                        'protection' => 'IP65',
                    ],
                    'preview' => 'svetovoj-korob-frontalnyj_intro.webp',
                    'detail' => 'svetovoj-korob-frontalnyj_hero.webp',
                ],
                [
                    'title' => 'Цельносветовой световой короб',
                    'filters' => ['Цельносветовая', 'Акрил'],
                    'excerpt' => 'Инновационный короб, где светятся все грани, создавая эффект светящегося объема.',
                    'content' => <<<'HTML'
            <p>Цельносветовой световой короб – современная альтернатива классическим лайтбоксам. Все грани короба (лицевая, боковые, иногда задняя) выполнены из светопрозрачных материалов. Специальная система светодиодов обеспечивает равномерное свечение всех поверхностей.</p>
            <p>Технология: используется рассеивающий акрил для лицевой части и прозрачный акрил с гравировкой или матированием для боковых граней. LED-модули располагаются таким образом, чтобы свет равномерно распределялся по всем плоскостям.</p>
            <p>Выглядит очень эффектно и современно. Используется для премиальных брендов, шоурумов, выставочных стендов.</p>
            HTML,
                    'properties' => [
                        'light_surface' => '100% (все грани)',
                        'material' => 'Акрил',
                        'technology' => 'Edge-LED / Back-LED',
                        'application' => 'Премиум сегмент',
                    ],
                    'preview' => 'svetovoj-korob-celnosvetovoj_intro.webp',
                    'detail' => 'svetovoj-korob-celnosvetovoj_hero.webp',
                ],
                [
                    'title' => 'Композитный короб с инкрустацией',
                    'filters' => ['Фронтальная', 'Композит'],
                    'excerpt' => 'Премиальный световой короб из композита с декоративными вставками.',
                    'content' => <<<'HTML'
            <p>Композитный короб с инкрустацией – эксклюзивное решение для наружной рекламы. Основной короб выполняется из композитных панелей (алюкобонд), а лицевая поверхность декорируется вставками из акрила, металла, дерева или других материалов с подсветкой или без.</p>
            <p>Технология инкрустации позволяет создавать сложные многослойные композиции, где одни элементы утоплены, другие выступают, создавая игру фактур и материалов. Подсветка может быть как общей для всего короба, так и локальной для отдельных вставок.</p>
            <p>Используется для бутиков, ресторанов, отелей – мест, где дизайн играет ключевую роль.</p>
            HTML,
                    'properties' => [
                        'technology' => 'Инкрустация',
                        'material' => 'Композит + Акрил / Металл / Дерево',
                        'design' => 'Эксклюзивный',
                        'application' => 'Премиум сегмент',
                    ],
                    'preview' => 'svetovoj-korob-inkrustaciya_intro.webp',
                    'detail' => 'svetovoj-korob-inkrustaciya_hero.webp',
                ],
                [
                    'title' => 'Композитный короб «на прорез»',
                    'filters' => ['Фронтальная', 'Композит'],
                    'excerpt' => 'Стильный короб с прорезными элементами и внутренней подсветкой.',
                    'content' => <<<'HTML'
            <p>Композитный короб "на прорез" – технология, при которой в лицевой композитной панели вырезаются элементы (буквы, логотип, графические детали), а с обратной стороны устанавливается подсветка. Свет проникает через прорези, создавая четкое контурное свечение.</p>
            <p>Днем короб выглядит как строгая композитная панель с графикой. Ночью прорезные элементы загораются, создавая эффектный световой рисунок. Возможно использование цветных светодиодов для создания дополнительных акцентов.</p>
            <p>Идеально подходит для современных офисов, банков, бизнес-центров, где ценится лаконичный дизайн.</p>
            HTML,
                    'properties' => [
                        'technology' => 'Прорезка',
                        'material' => 'Композит',
                        'light' => 'Внутренняя LED',
                        'design' => 'Минимализм',
                    ],
                    'preview' => 'svetovoj-korob-prorez_intro.webp',
                    'detail' => 'svetovoj-korob-prorez_hero.webp',
                ],
                [
                    'title' => 'Фигурный световой короб',
                    'filters' => ['Фронтальная', 'Акрил', 'Фигурный'],
                    'excerpt' => 'Световой короб любой сложной формы, повторяющий контуры логотипа или персонажа.',
                    'content' => <<<'HTML'
            <p>Фигурный световой короб – это лайтбокс, форма которого не ограничивается прямоугольником или квадратом. Он может повторять очертания логотипа, товарного знака, персонажа, любой сложной геометрической формы.</p>
            <p>Изготовление таких коробов требует более сложной технологии: разработки индивидуальной развертки, фрезеровки сложных форм, ручной сборки криволинейных элементов. Но результат оправдывает затраты – вы получаете уникальный рекламный носитель, максимально соответствующий вашему фирменному стилю.</p>
            <p>Применяется для ключевых объектов, где важно максимальное соответствие бренду – флагманские магазины, выставочные стенды, парки развлечений.</p>
            HTML,
                    'properties' => [
                        'shape' => 'Индивидуальная',
                        'material' => 'Акрил + Композит',
                        'complexity' => 'Высокая',
                        'application' => 'Уникальные проекты',
                    ],
                    'preview' => 'svetovoj-korob-figurnyj_intro.webp',
                    'detail' => 'svetovoj-korob-figurnyj_hero.webp',
                ],
            ],

            /* -------------------------------------------------
     | 4. ПАНЕЛЬ-КРОНШТЕЙНЫ
     -------------------------------------------------*/
            'Панель-кронштейны' => [
                [
                    'title' => 'Двухсторонний панель-кронштейн',
                    'filters' => ['Двухсторонний', 'Стандарт'],
                    'excerpt' => 'Классическая двухсторонняя вывеска на кронштейне для хорошей видимости с обеих сторон.',
                    'content' => <<<'HTML'
            <p>Двухсторонний панель-кронштейн – эффективный рекламоноситель, монтируемый перпендикулярно фасаду здания. Информация наносится с обеих сторон, что обеспечивает видимость при движении в любом направлении.</p>
            <p>Конструкция состоит из двух панелей (из композита, ПВХ, акрила), скрепленных между собой, и металлического кронштейна, выносящего конструкцию на 500-1500 мм от стены. Возможно исполнение с подсветкой (внутренней или внешней) или без.</p>
            <p>Используется для обозначения входов в магазины, аптеки, кафе, салоны красоты на оживленных улицах. Отличная видимость как для пешеходов, так и для водителей.</p>
            HTML,
                    'properties' => [
                        'visibility' => '360° (двухсторонняя)',
                        'material' => 'Композит / ПВХ / Акрил',
                        'mounting' => 'Кронштейн 0.5–1.5 м',
                        'application' => 'Фасады',
                    ],
                    'preview' => 'panel-kronshtejn-dvustoronnij_intro.webp',
                    'detail' => 'panel-kronshtejn-dvustoronnij_hero.webp',
                ],
                [
                    'title' => 'Двухсторонний композитный панель-кронштейн «на прорез»',
                    'filters' => ['Двухсторонний', 'Композит «на прорез»'],
                    'excerpt' => 'Стильный двухсторонний кронштейн с прорезными светящимися элементами.',
                    'content' => <<<'HTML'
            <p>Двухсторонний композитный панель-кронштейн "на прорез" – современное дизайнерское решение. В композитных панелях вырезаются элементы (буквы, логотип), а внутри конструкции устанавливается подсветка. Свет проникает через прорези с обеих сторон, создавая четкое контурное свечение.</p>
            <p>Днем конструкция выглядит как строгие композитные панели с графикой. Ночью прорезные элементы загораются, делая вывеску яркой и заметной с дальнего расстояния. Возможно использование RGB-подсветки для создания цветовых акцентов.</p>
            <p>Идеально подходит для современных торговых центров, бизнес-центров, ресторанов, где важен стильный, технологичный вид.</p>
            HTML,
                    'properties' => [
                        'technology' => 'Прорезка с подсветкой',
                        'material' => 'Композит',
                        'visibility' => 'Двухсторонняя',
                        'light' => 'Внутренняя LED',
                    ],
                    'preview' => 'panel-kronshtejn-prorez_intro.webp',
                    'detail' => 'panel-kronshtejn-prorez_hero.webp',
                ],
            ],

            /* -------------------------------------------------
     | 5. ИНТЕРЬЕРНЫЕ СВЕТОВЫЕ ПАНЕЛИ
     -------------------------------------------------*/
            'Интерьерные световые панели' => [
                [
                    'title' => 'Тейбл тент',
                    'filters' => ['A4', 'Настольный'],
                    'excerpt' => 'Компактные настольные световые панели для меню, акций и информационных материалов.',
                    'content' => <<<'HTML'
            <p>Тейбл тент (Table tent) – настольная световая панель, идеально подходящая для размещения меню, акционных предложений, информационных материалов в кафе, ресторанах, отелях, на стойках ресепшн.</p>
            <p>Конструкция: тонкий (8-12 мм) световой короб из акрила с равномерной LED-подсветкой. Двухстороннее исполнение позволяет размещать информацию с обеих сторон. Форматы – А4, А5, евро, возможны нестандартные размеры. Питание от USB или батареек.</p>
            <p>Мягкое свечение привлекает внимание к размещенной информации и создает уютную атмосферу в заведении. Сменные вкладыши позволяют легко обновлять информацию.</p>
            HTML,
                    'properties' => [
                        'formats' => 'A4 / A5 / Евро',
                        'type' => 'Настольный',
                        'light' => 'LED',
                        'power' => 'USB / Батарейки',
                    ],
                    'preview' => 'interernye-tejbltent_intro.webp',
                    'detail' => 'interernye-tejbltent_hero.webp',
                ],
                [
                    'title' => 'Кристалайт Crystal',
                    'filters' => ['A3', 'Настенный'],
                    'excerpt' => 'Премиальные световые панели с эффектом кристального свечения в трех размерах.',
                    'content' => <<<'HTML'
            <p>Кристалайт Crystal – премиальная серия интерьерных световых панелей с уникальным эффектом кристальной глубины. Многослойная структура создает объемное свечение, меняющееся при изменении угла обзора.</p>
            <p>Доступны в трех вариантах исполнения (S, M, L), отличающихся размерами и конфигурацией. Панели могут использоваться для размещения логотипов, навигационных указателей, декоративных элементов. Корпус – алюминий, лицевая часть – специальный акрил с микрорельефом.</p>
            <p>Идеально подходят для оформления премиальных бутиков, салонов, отелей, выставочных залов.</p>
            HTML,
                    'properties' => [
                        'types' => '3 варианта (S, M, L)',
                        'effect' => 'Кристальное свечение',
                        'material' => 'Акрил + Алюминий',
                        'application' => 'Премиум интерьеры',
                    ],
                    'preview' => 'interernye-crystal_intro.webp',
                    'detail' => 'interernye-crystal_hero.webp',
                ],
                [
                    'title' => 'Crystal Round',
                    'filters' => ['A3', 'Подвесной'],
                    'excerpt' => 'Круглые световые панели с эффектом кристалла для создания мягких интерьерных композиций.',
                    'content' => <<<'HTML'
            <p>Crystal Round – круглая версия популярных панелей Crystal. Мягкая круглая форма позволяет создавать гармоничные композиции, хорошо вписывающиеся в современные интерьеры. Эффект кристальной глубины сохраняется и в круглом формате.</p>
            <p>Доступны в трех типоразмерах, что дает возможность комбинировать панели для создания уникальных световых инсталляций, акцентных стен, указателей. Могут использоваться как подвесные (на тросах) или настенные конструкции.</p>
            <p>Особенно эффектно смотрятся в композициях из нескольких панелей разного диаметра. Подходят для торговых центров, выставочных пространств, холлов.</p>
            HTML,
                    'properties' => [
                        'shape' => 'Круглый',
                        'sizes' => '3 диаметра',
                        'mount' => 'Подвесной / Настенный',
                        'effect' => 'Кристальное свечение',
                    ],
                    'preview' => 'interernye-crystal-round_intro.webp',
                    'detail' => 'interernye-crystal-round_hero.webp',
                ],
                [
                    'title' => 'Frame панель',
                    'filters' => ['A2', 'Настенный'],
                    'excerpt' => 'Строгие световые панели в алюминиевой рамке для современного минималистичного интерьера.',
                    'content' => <<<'HTML'
            <p>Frame – серия световых панелей в стиле минимализм с тонкой алюминиевой рамкой. Панели имеют строгий, лаконичный дизайн и подходят для оформления офисов, медицинских центров, салонов красоты, где требуется сочетание функциональности и элегантности.</p>
            <p>Конструкция: световая панель с равномерной подсветкой заключена в тонкую (10 мм) алюминиевую рамку с матовым или полированным покрытием. Доступны форматы от А4 до А2 и нестандартные размеры. Цвет рамки может быть выбран по RAL.</p>
            <p>Равномерное свечение без темных пятен обеспечивается специальной светорассеивающей подложкой. Отлично смотрятся как одиночные элементы или в композициях.</p>
            HTML,
                    'properties' => [
                        'frame' => 'Алюминий 10 мм',
                        'formats' => 'A4 / A3 / A2',
                        'design' => 'Минимализм',
                        'application' => 'Офисы / Медцентры',
                    ],
                    'preview' => 'interernye-frame_intro.webp',
                    'detail' => 'interernye-frame_hero.webp',
                ],
                [
                    'title' => 'Magnetic панель',
                    'filters' => ['A4', 'Настольный'],
                    'excerpt' => 'Инновационные панели с магнитным креплением для быстрой смены информационных вставок.',
                    'content' => <<<'HTML'
            <p>Magnetic – инновационная серия панелей с магнитным креплением информационных вставок. Основой служит световая панель с равномерной подсветкой, на которую с помощью магнитов крепятся сменные элементы с информацией – логотипы, указатели, ценники, меню.</p>
            <p>Позволяет быстро и без инструментов менять содержание панели, что особенно актуально для магазинов, кафе, выставочных стендов с часто обновляемой информацией. Магниты надежно фиксируют вставки, исключая их самопроизвольное смещение.</p>
            <p>Доступны настольные и настенные версии. Форматы – А4, А5, квадратные, круглые. Идеальное решение для динамичного бизнеса с часто меняющимися акциями.</p>
            HTML,
                    'properties' => [
                        'mount' => 'Магнитный',
                        'change' => 'Быстрая смена',
                        'formats' => 'A4 / A5 / Квадрат / Круг',
                        'application' => 'Ритейл / HoReCa',
                    ],
                    'preview' => 'interernye-magnetic_intro.webp',
                    'detail' => 'interernye-magnetic_hero.webp',
                ],
            ],

            /* -------------------------------------------------
     | 6. СОВРЕМЕННЫЕ ВЫВЕСКИ
     -------------------------------------------------*/
            'Современные вывески' => [
                [
                    'title' => 'Текстильные лайтбоксы',
                    'filters' => ['Текстиль', 'Фасад'],
                    'excerpt' => 'Легкие световые короба с натяжным текстильным полотном и яркой печатью.',
                    'content' => <<<'HTML'
            <p>Текстильные лайтбоксы – современная альтернатива классическим жестким коробам. Вместо акрила используется специальная светорассеивающая ткань (backlit fabric), натянутая на алюминиевый профиль. Это дает ряд преимуществ:</p>
            <ul>
                <li>Малый вес – легко монтируются даже на легкие конструкции;</li>
                <li>Безупречно ровная поверхность без бликов;</li>
                <li>Возможность создания любых форм, включая сложные криволинейные;</li>
                <li>Простота замены изображения – достаточно сменить тканевый чехол;</li>
                <li>Мягкое, равномерное свечение без "эффекта сот".</li>
            </ul>
            <p>Используются для выставочных стендов, временных акций, интерьеров с требованием к частой смене рекламных материалов. Качество печати – фотографическое, цвета яркие и насыщенные.</p>
            HTML,
                    'properties' => [
                        'fabric' => 'Backlit текстиль',
                        'print' => 'Полноцветная',
                        'weight' => 'Легкий',
                        'application' => 'Выставки / Интерьеры',
                    ],
                    'preview' => 'sovremennye-tekstilnye_intro.webp',
                    'detail' => 'sovremennye-tekstilnye_hero.webp',
                ],
                [
                    'title' => 'Акрилайты',
                    'filters' => ['Акрил', 'Интерьер'],
                    'excerpt' => 'Стильные вывески из объемного акрила с торцевой подсветкой для интерьеров.',
                    'content' => <<<'HTML'
            <p>Акрилайты – вывески из объемного акрила с боковой (торцевой) подсветкой. Светодиоды устанавливаются по торцам акрилового элемента, и свет распространяется внутри материала, высвечивая гравировку или делая светящимися края буквы. Создается эффект "ледяного" свечения – мягкого, загадочного, необычного.</p>
            <p>Технология позволяет создавать эффекты свечения различного цвета, в том числе многоцветные в одном элементе. Гравировка на поверхности акрила может быть как сквозной, так и поверхностной, создавая дополнительные световые акценты.</p>
            <p>Акрилайты могут быть выполнены в виде букв, логотипов, абстрактных форм и особенно эффектно смотрятся в интерьерах с приглушенным освещением – барах, ресторанах, ночных клубах.</p>
            HTML,
                    'properties' => [
                        'light' => 'Торцевая (Edge)',
                        'material' => 'Акрил',
                        'effect' => 'Ледяное свечение',
                        'application' => 'Интерьеры',
                    ],
                    'preview' => 'sovremennye-akrilajty_intro.webp',
                    'detail' => 'sovremennye-akrilajty_hero.webp',
                ],
                [
                    'title' => 'Неоновые вывески',
                    'filters' => ['Неон', 'Интерьер'],
                    'excerpt' => 'Яркие неоновые вывески из гибкого LED-неона для создания атмосферы и привлечения внимания.',
                    'content' => <<<'HTML'
            <p>Неоновые вывески – главный тренд в оформлении интерьеров кафе, баров, кофеен, магазинов одежды и косметики. Современные неоновые вывески используют не стеклянные газонаполненные трубки, а гибкий LED-неон – светодиодный шнур в ПВХ-оболочке.</p>
            <p>Преимущества LED-неона:</p>
            <ul>
                <li>Безопасность – низкое напряжение 12/24V, отсутствие хрупкого стекла;</li>
                <li>Гибкость – можно создавать любые формы и даже объемные композиции;</li>
                <li>Яркость и насыщенность цвета (доступно 8+ цветов);</li>
                <li>Долговечность – срок службы до 50 000 часов;</li>
                <li>Простота монтажа и обслуживания.</li>
            </ul>
            <p>Яркие светящиеся фразы, слоганы, рисунки создают неповторимую атмосферу и становятся любимым фоном для фото в социальных сетях.</p>
            HTML,
                    'properties' => [
                        'technology' => 'LED Neon (гибкий)',
                        'colors' => '8+ цветов',
                        'voltage' => '12V / 24V',
                        'application' => 'Интерьеры / Фасады',
                    ],
                    'preview' => 'sovremennye-neon_intro.webp',
                    'detail' => 'sovremennye-neon_hero.webp',
                ],
            ],

            /* -------------------------------------------------
     | 7. НАВИГАЦИЯ
     -------------------------------------------------*/
            'Навигация' => [
                [
                    'title' => 'Информационные стенды',
                    'filters' => ['Стенд', 'Композит'],
                    'excerpt' => 'Функциональные стенды для размещения справочной информации в общественных пространствах.',
                    'content' => <<<'HTML'
            <p>Информационные стенды – неотъемлемый элемент навигации в торговых центрах, бизнес-центрах, государственных учреждениях. Они помогают посетителям легко ориентироваться, находить нужные отделы, кабинеты, услуги.</p>
            <p>Виды стендов:</p>
            <ul>
                <li>Настенные – компактные, не занимают полезную площадь;</li>
                <li>Напольные (мобильные) – на устойчивой подставке, можно переставлять;</li>
                <li>Подвесные – крепятся к потолку, хорошо видны издалека;</li>
                <li>С вращающимся механизмом – для удобства просмотра с разных сторон.</li>
            </ul>
            <p>Стенды могут быть плоскостными (информация наносится непосредственно на поверхность) или кармашкового типа (со сменными вкладышами А4, А3). Возможно оснащение подсветкой.</p>
            HTML,
                    'properties' => [
                        'usage' => 'ТЦ / БЦ / Госучреждения',
                        'material' => 'Композит / ПВХ / Акрил',
                        'types' => 'Настенные / Напольные / Подвесные',
                        'info' => 'Плоскостные / Кармашковые',
                    ],
                    'preview' => 'navigaciya-stendy_intro.webp',
                    'detail' => 'navigaciya-stendy_hero.webp',
                ],
                [
                    'title' => 'Информационные таблички',
                    'filters' => ['Табличка', 'Пластик'],
                    'excerpt' => 'Компактные таблички для кабинетов, отделов и функциональных зон.',
                    'content' => <<<'HTML'
            <p>Информационные таблички – компактные указатели для кабинетов, отделов, функциональных зон. Помогают посетителям ориентироваться внутри помещений, создают структурированное пространство.</p>
            <p>Основные виды:</p>
            <ul>
                <li>Кабинетные – с названием отдела, должностью, именем сотрудника;</li>
                <li>Указатели направления – со стрелками и пиктограммами;</li>
                <li>Режимные – с информацией о часах работы, правилах поведения;</li>
                <li>Предписывающие и запрещающие – "вход", "выход", "курить запрещено".</li>
            </ul>
            <p>Материалы: пластик (ПВХ, акрил), металл (латунь, нержавейка), дерево, композит. Нанесение информации – УФ-печать, гравировка, пленка. Для людей с ограниченными возможностями – таблички с шрифтом Брайля.</p>
            HTML,
                    'properties' => [
                        'usage' => 'Офисы / Учреждения',
                        'material' => 'Пластик / Металл / Дерево',
                        'braille' => 'Опционально',
                        'mount' => 'Стеновое',
                    ],
                    'preview' => 'navigaciya-tablichki_intro.webp',
                    'detail' => 'navigaciya-tablichki_hero.webp',
                ],
            ],

            /* -------------------------------------------------
     | 8. POSM И ПОЛИГРАФИЯ
     -------------------------------------------------*/
            'POSM и Полиграфия' => [
                [
                    'title' => 'POSM-изделия из пластика',
                    'filters' => ['POSM', 'Пластик'],
                    'excerpt' => 'Рекламные материалы для точек продаж: ценникодержатели, воблеры, диспенсеры, подставки.',
                    'content' => <<<'HTML'
            <p>POSM-изделия (Point of Sales Materials) – рекламные материалы, используемые непосредственно в местах продаж для привлечения внимания к товару, информирования о свойствах, стимулирования импульсных покупок.</p>
            <p>Ассортимент включает:</p>
            <ul>
                <li>Ценникодержатели – настольные, навесные, на магнитах, для любых типов полок;</li>
                <li>Воблеры – гибкие подвесные элементы, привлекающие внимание;</li>
                <li>Шелфтокеры – удлинители полок с рекламным блоком;</li>
                <li>Диспенсеры – для листовок, визиток, буклетов;</li>
                <li>Стопперы – напольные фигуры и конструкции;</li>
                <li>Подставки под товар – для выкладки в оптимальном ракурсе.</li>
            </ul>
            <p>Прозрачное оргстекло не перекрывает обзор товара. Цветной пластик используется для создания ярких акцентов, соответствующих фирменному стилю бренда.</p>
            HTML,
                    'properties' => [
                        'usage' => 'Ритейл / Выставки',
                        'material' => 'Акрил / ПВХ / Полистирол',
                        'types' => 'Ценникодержатели / Воблеры / Диспенсеры / Подставки',
                        'print' => 'УФ-печать / Шелкография',
                    ],
                    'preview' => 'posm-plastik_intro.webp',
                    'detail' => 'posm-plastik_hero.webp',
                ],
                [
                    'title' => 'Печатная продукция',
                    'filters' => ['Полиграфия', 'Бумага'],
                    'excerpt' => 'Широкий ассортимент полиграфической продукции: листовки, буклеты, каталоги, плакаты.',
                    'content' => <<<'HTML'
            <p>Полиграфическая продукция – классический и эффективный инструмент маркетинга. Мы предлагаем полный спектр услуг по печати рекламных и информационных материалов любого формата и тиража.</p>
            <p>Виды продукции:</p>
            <ul>
                <li>Листовки, флаеры, буклеты – для раздачи и распространения;</li>
                <li>Каталоги, брошюры – многостраничная продукция с подробным описанием товаров;</li>
                <li>Плакаты, постеры – для оформления интерьеров, витрин, стендов;</li>
                <li>Календари – настольные, настенные, карманные, квартальные;</li>
                <li>Блокноты, ежедневники – сувенирная продукция с брендированием;</li>
                <li>Открытки, приглашения – для специальных мероприятий.</li>
            </ul>
            <p>Виды печати: цифровая (малые тиражи), офсетная (большие тиражи), широкоформатная (постеры). Постпечатная обработка: ламинация, тиснение, вырубка.</p>
            HTML,
                    'properties' => [
                        'types' => 'Листовки / Буклеты / Каталоги / Плакаты / Календари',
                        'print' => 'Цифровая / Офсетная / Широкоформатная',
                        'paper' => 'Мелованная / Офсетная / Дизайнерская',
                        'finishing' => 'Ламинация / Тиснение / Вырубка',
                    ],
                    'preview' => 'posm-poligrafiya_intro.webp',
                    'detail' => 'posm-poligrafiya_hero.webp',
                ],
            ],
        ];
        foreach ($data as $categoryTitle => $products) {
            $category = ProductCategory::where('title', $categoryTitle)->first();

            foreach ($products as $sort => $item) {
                $attachment = Attachment::where('original_name', $item['preview'])->first();
                $properties = is_array($item['properties'])
                                ? json_encode($item['properties'])
                                : $item['properties'];
                if (! $attachment) {
                    $image_id = $category->preview_id;
                } else {
                    $image_id = $attachment->id;
                }
                $product = Product::create([
                    'title' => $item['title'],
                    'slug' => Str::slug($item['title']),
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'category_id' => $category->id,
                    'properties' => $properties,
                    'sort' => $sort,
                    'active' => true,
                    'preview_id' => $image_id,
                    'detail_id' => $image_id,
                    'published_at' => now(),
                ]);

                $filterValueIds = ProductCategoryFilterValue::whereIn(
                    'value',
                    $item['filters']
                )->pluck('id');

                $product->filterValues()->sync($filterValueIds);
            }
        }
    }
}

```

### database/seeders/RolesAndPermissionsSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Администратор (полный доступ)
        Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Администратор',
                'permissions' => [
                    'platform.index' => true,
                    'platform.systems.roles' => true,
                    'platform.systems.users' => true,
                    'platform.systems.attachment' => true,
                    // Все остальные права
                ],
            ]
        );

        // Менеджер (только заявки)
        Role::updateOrCreate(
            ['slug' => 'manager'],
            [
                'name' => 'Менеджер',
                'permissions' => [
                    'platform.index' => true,
                    'platform.leads.list' => true,
                    'platform.leads.view' => true,
                    'platform.leads.export' => true,
                ],
            ]
        );
    }
}

```

### database/seeders/SEOSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\SEO;
use Illuminate\Database\Seeder;
use Orchid\Attachment\Models\Attachment;

class SEOSeeder extends Seeder
{
    /**
     * SEO данные для статических страниц
     */
    protected array $seoData = [
        [
            'page_slug' => 'about',
            'data' => [
                'title' => 'О компании Нарратив | Производство и монтаж наружной рекламы',
                'description' => 'Компания «Нарратив» — полный цикл производства наружной рекламы: от дизайна до монтажа. Собственный цех 800 м², современное оборудование, гарантия 1 год. Более 500 реализованных проектов с 2010 года.',
                'keywords' => 'производство наружной рекламы, монтаж вывесок, изготовление объемных букв, световые короба, наружная реклама Самара, компания Нарратив',
                'og_image' => 'about_hero.webp',
                'og_title' => 'Нарратив — производим наружную рекламу, которая рассказывает истории',
                'og_description' => 'С 2010 года создаем вывески, которые работают на ваш бренд. Полный цикл: дизайн, производство в цеху 800 м², монтаж на высоте. Более 500 довольных клиентов.',
                'robots' => 'index, follow',
            ],
        ],
        [
            'page_slug' => 'contacts',
            'data' => [
                'title' => 'Контакты — Нарратив | Производство наружной рекламы в Самаре',
                'description' => 'Свяжитесь с нами для заказа наружной рекламы. Адрес производства, телефон, email и реквизиты компании Нарратив. Бесплатный выезд на замер и консультация.',
                'keywords' => 'контакты нарратив, адрес производства наружной рекламы, телефон рекламного агентства, заказать вывеску Самара',
                'og_image' => 'contacts_hero.webp',
                'og_title' => 'Свяжитесь с нами — Нарратив',
                'og_description' => 'Приезжайте к нам в цех или оставьте заявку онлайн. Обсудим ваш проект и рассчитаем смету.',
                'robots' => 'index, follow',
            ],
        ],
        [
            'page_slug' => 'equipment',
            'data' => [
                'title' => 'Оборудование и технологии — Нарратив | Собственный цех 800 м² в Самаре',
                'description' => 'Производство наружной рекламы на современном оборудовании: фрезерные и лазерные станки с ЧПУ, УФ-печать. Цех 800 м², точность до 0,05 мм. Полный контроль качества без субподряда.',
                'keywords' => 'оборудование для наружной рекламы, фрезерный станок с чпу, лазерная резка акрила, широкоформатная печать, производственный цех рекламы, станки для вывесок, нарратив оборудование',
                'og_image' => 'equipment_hero.webp',
                'og_title' => 'Цех полного цикла: смотрите наше оборудование',
                'og_description' => 'Лазерная резка, фрезеровка, УФ-печать и работа с LED. 7 единиц ЧПУ-техники и собственная производственная база 800 м².',
                'robots' => 'index, follow',
            ],
        ],
        // Здесь можно будет добавлять новые страницы:
        // [
        //     'page_slug' => 'portfolio',
        //     'data' => [...],
        // ],
        // [
        //     'page_slug' => 'catalog',
        //     'data' => [...],
        // ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->seoData as $item) {
            $page = Page::where('slug', $item['page_slug'])->first();

            if (! $page) {
                $this->command->warn("Страница с slug '{$item['page_slug']}' не найдена. Пропускаем...");

                continue;
            }

            // Получаем изображение для Open Graph
            $ogImage = isset($item['data']['og_image'])
                ? Attachment::where('original_name', $item['data']['og_image'])->first()
                : null;

            // Базовые SEO данные
            $seoData = [
                'title' => $item['data']['title'],
                'description' => $item['data']['description'],
                'keywords' => $item['data']['keywords'] ?? null,
                'og_title' => $item['data']['og_title'] ?? $item['data']['title'],
                'og_description' => $item['data']['og_description'] ?? $item['data']['description'],
                'og_image_id' => $ogImage?->id,
                'canonical_url' => $item['data']['canonical_url'] ?? null,
                'robots' => $item['data']['robots'] ?? 'index, follow',
            ];

            // Создаем или обновляем SEO запись
            SEO::updateOrCreate(
                [
                    'seoable_type' => Page::class,
                    'seoable_id' => $page->id,
                ],
                $seoData
            );

            $this->command->info("SEO данные для страницы '{$page->title}' добавлены.");
        }

        $this->command->info('Все SEO данные успешно обработаны.');
    }
}

```

### database/seeders/ServiceSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Service;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;
use Orchid\Attachment\Models\Attachment;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Изготовление вывесок',
                'excerpt' => 'Производство наружных и интерьерных вывесок любой сложности.',
                'content' => <<<'HTML'
<p>Мы изготавливаем наружные и интерьерные вывески под ключ: от разработки дизайна до монтажа. Работаем с объёмными буквами, световыми коробами, неоном и комбинированными решениями.</p>

<h2>Виды вывесок</h2>
<p>В зависимости от задачи бизнеса и особенностей фасада мы предлагаем несколько типов вывесок:</p>
<ul>
  <li><strong>Объёмные буквы</strong> — металлические или пластиковые, с подсветкой или без. Создают солидный образ бренда.</li>
  <li><strong>Световые короба</strong> — алюминиевая рамка с подсвеченным лайтбоксом. Хорошо видны ночью, просты в обслуживании.</li>
  <li><strong>Неоновые и LED-неоновые вывески</strong> — яркие, привлекательные, с индивидуальным контуром любой формы.</li>
  <li><strong>Несветовые вывески</strong> — таблички, композитные панели, фрезерованные буквы без подсветки.</li>
  <li><strong>Комбинированные конструкции</strong> — объёмные буквы на световом коробе, элементы с подсветкой и без — по запросу.</li>
</ul>

<h2>Материалы</h2>
<p>Используем только проверенные материалы: нержавеющую сталь, алюминиевый профиль, акрил, композитные панели, влагостойкий МДФ. Все комплектующие (трансформаторы, LED-модули) — сертифицированные, с гарантией производителя.</p>

<h2>Стоимость</h2>
<table>
  <thead>
    <tr><th>Тип вывески</th><th>Стоимость от</th></tr>
  </thead>
  <tbody>
    <tr><td>Несветовая вывеска (таблички, буквы)</td><td>от 5 000 руб.</td></tr>
    <tr><td>Световой короб</td><td>от 15 000 руб.</td></tr>
    <tr><td>Объёмные буквы без подсветки</td><td>от 10 000 руб.</td></tr>
    <tr><td>Объёмные буквы с подсветкой</td><td>от 20 000 руб.</td></tr>
    <tr><td>LED-неон (1 пог. м)</td><td>от 3 500 руб.</td></tr>
  </tbody>
</table>
<p>Точная стоимость рассчитывается индивидуально после уточнения размеров, материалов и сложности конструкции.</p>
HTML,
                'price_from' => 15000,
                'preview' => 'izgotovlenie-vyvesok.webp',
                'sort' => 10,
                'properties' => [
                    ['key' => 'Минимальный срок изготовления', 'value' => 'от 3 рабочих дней'],
                    ['key' => 'Максимальный размер', 'value' => 'без ограничений (секционно)'],
                    ['key' => 'Подсветка', 'value' => 'LED, неон, без подсветки'],
                    ['key' => 'Материалы', 'value' => 'нержавеющая сталь, акрил, алюминий, МДФ, композит'],
                    ['key' => 'Монтаж', 'value' => 'входит в стоимость (под ключ)'],
                ],
                'guarantee' => '2 года',
                'process_steps' => [
                    ['key' => 'Заявка и консультация', 'value' => 'Вы описываете задачу — по телефону, в мессенджере или на сайте. Менеджер уточняет требования, задаёт вопросы по материалам, размерам, срокам.'],
                    ['key' => 'Выезд на замер', 'value' => 'Технолог выезжает на объект, измеряет фасад, изучает конструктив здания, фотографирует. Определяем оптимальный способ монтажа.'],
                    ['key' => 'Разработка дизайна и КП', 'value' => 'Дизайнер готовит визуализацию вывески на фото фасада. Вы видите результат до начала производства. Вносим правки до вашего одобрения.'],
                    ['key' => 'Договор и предоплата', 'value' => 'Согласуем финальный дизайн, подписываем договор. Предоплата 50%, остаток — после монтажа. Указываем фиксированные сроки с неустойкой.'],
                    ['key' => 'Производство', 'value' => 'Изготавливаем вывеску в нашем цехе. Каждый элемент проходит ОТК: геометрия, подсветка, механические соединения. Фото- и видеоотчёт с производства.'],
                    ['key' => 'Монтаж и сдача', 'value' => 'Бригада монтирует вывеску, подключает питание, проверяет работу. Подписываем акт приёма-передачи, передаём гарантийный талон и паспорт изделия.'],
                ],
            ],

            [
                'title' => 'Фрезеровка',
                'excerpt' => 'Фрезерная обработка пластика, композита, МДФ и других материалов.',
                'content' => <<<'HTML'
<p>Фрезеровка — один из ключевых производственных процессов при изготовлении рекламных конструкций, вывесок, элементов декора и навигации. На нашем ЧПУ-оборудовании мы обрабатываем листовые материалы с высокой точностью и чистотой реза.</p>

<h2>Что такое фрезеровка</h2>
<p>Фрезеровка — это механическая обработка материала вращающимся инструментом (фрезой). Станок с числовым программным управлением (ЧПУ) вырезает детали по контуру, формирует карманы, снимает фаски и гравирует поверхности по заданному цифровому макету. Это позволяет добиться точности до 0,1 мм при изготовлении тиражных и единичных изделий.</p>

<h2>Обрабатываемые материалы</h2>
<ul>
  <li>Пластик: акрил (оргстекло), ПВХ, полистирол, ABS</li>
  <li>Композитные панели (алюкобонд)</li>
  <li>МДФ и фанера</li>
  <li>Вспененный ПВХ (пенопласт строительный — нет; ПВХ-пена — да)</li>
  <li>Мягкие металлы: алюминий до 5 мм</li>
</ul>

<h2>Применение в рекламе</h2>
<p>Фрезеровка используется при изготовлении объёмных букв и логотипов, лицевых панелей световых коробов, навигационных табличек, декоративных панелей для интерьерного оформления, подложек под объёмные конструкции.</p>

<h2>Стоимость фрезеровки</h2>
<table>
  <thead>
    <tr><th>Материал</th><th>Толщина, мм</th><th>Стоимость реза, руб./пог. м</th></tr>
  </thead>
  <tbody>
    <tr><td>Акрил / оргстекло</td><td>3–5</td><td>от 60</td></tr>
    <tr><td>Акрил / оргстекло</td><td>6–10</td><td>от 90</td></tr>
    <tr><td>ПВХ-пена</td><td>3–10</td><td>от 50</td></tr>
    <tr><td>МДФ</td><td>6–19</td><td>от 70</td></tr>
    <tr><td>Алюминий</td><td>2–5</td><td>от 150</td></tr>
    <tr><td>Композит</td><td>3–4</td><td>от 80</td></tr>
  </tbody>
</table>
<p>Минимальная стоимость заказа — 3 000 руб. Стоимость материала рассчитывается отдельно.</p>
HTML,
                'price_from' => 3000,
                'preview' => 'frezerovka.webp',
                'sort' => 20,
                'properties' => [
                    ['key' => 'Точность обработки', 'value' => 'до 0,1 мм'],
                    ['key' => 'Максимальный размер заготовки', 'value' => '2440 × 1220 мм'],
                    ['key' => 'Материалы', 'value' => 'акрил, ПВХ, МДФ, фанера, алюминий, композит'],
                    ['key' => 'Минимальный заказ', 'value' => '3 000 руб.'],
                    ['key' => 'Срок выполнения', 'value' => 'от 1 рабочего дня'],
                ],
                'guarantee' => '1 год на изделие',
                'process_steps' => [
                    ['key' => 'Передача макета', 'value' => 'Вы передаёте файл в формате DXF, AI, CDR или PDF. Если макета нет — наш технолог подготовит его по вашему эскизу или образцу.'],
                    ['key' => 'Проверка и подготовка', 'value' => 'Технолог проверяет макет на технологичность, уточняет материал и толщину, рассчитывает стоимость и сроки.'],
                    ['key' => 'Производство', 'value' => 'Запускаем заготовку на ЧПУ-станок. Автоматическое управление обеспечивает точное воспроизведение контура.'],
                    ['key' => 'Контроль качества', 'value' => 'Готовые детали проверяем на соответствие размерам, чистоту реза и отсутствие сколов.'],
                    ['key' => 'Выдача или доставка', 'value' => 'Упаковываем изделия и передаём заказчику. Возможна доставка по городу.'],
                ],
            ],

            [
                'title' => 'Лазерная резка',
                'excerpt' => 'Точная лазерная резка акрила, пластика, фанеры и тонких металлов.',
                'content' => <<<'HTML'
<p>Лазерная резка — высокоточный бесконтактный способ обработки листовых материалов. Сфокусированный световой луч прорезает материал по цифровому контуру, обеспечивая идеально ровный рез и минимальные отходы. Подходит для деталей любой сложной формы.</p>

<h2>Преимущества лазерной резки</h2>
<ul>
  <li>Точность до 0,05 мм — идеально для мелких деталей и сложных контуров</li>
  <li>Гладкая кромка без заусенцев и последующей обработки</li>
  <li>Нет механического давления на заготовку — материал не деформируется</li>
  <li>Возможность гравировки и раскроя в одном цикле</li>
  <li>Быстрое производство тиражных деталей</li>
</ul>

<h2>Обрабатываемые материалы</h2>
<ul>
  <li>Акрил (оргстекло) — литой и экструзионный, от 1 до 20 мм</li>
  <li>Фанера и дерево — до 20 мм</li>
  <li>ПЭТ, полистирол, ПВХ</li>
  <li>Картон, бумага</li>
  <li>Тонкие металлы (нержавейка, медь) — специализированным оборудованием</li>
</ul>

<h2>Применение</h2>
<p>Лазерная резка используется при изготовлении фигурных элементов вывесок и декора, сувенирной продукции, табличек и навигационных знаков, шаблонов и трафаретов, POS-материалов.</p>

<h2>Стоимость лазерной резки</h2>
<table>
  <thead>
    <tr><th>Материал</th><th>Толщина, мм</th><th>Стоимость, руб./пог. м</th></tr>
  </thead>
  <tbody>
    <tr><td>Фанера</td><td>3–4</td><td>от 20</td></tr>
    <tr><td>Фанера</td><td>6–10</td><td>от 40</td></tr>
    <tr><td>Акрил / оргстекло</td><td>1–3</td><td>от 25</td></tr>
    <tr><td>Акрил / оргстекло</td><td>4–5</td><td>от 40</td></tr>
    <tr><td>Полистирол / ПЭТ</td><td>2–5</td><td>от 35</td></tr>
  </tbody>
</table>
<p>Минимальная стоимость заказа — 3 000 руб. Стоимость материала и подготовка макета рассчитываются отдельно.</p>
HTML,
                'price_from' => 3000,
                'preview' => 'lazernaya-rezka.webp',
                'sort' => 30,
                'properties' => [
                    ['key' => 'Точность', 'value' => 'до 0,05 мм'],
                    ['key' => 'Максимальный размер поля', 'value' => '1300 × 900 мм'],
                    ['key' => 'Материалы', 'value' => 'акрил, фанера, ПВХ, ПЭТ, полистирол, картон'],
                    ['key' => 'Минимальный заказ', 'value' => '3 000 руб.'],
                    ['key' => 'Возможности', 'value' => 'резка, гравировка, перфорация'],
                ],
                'guarantee' => 'на соответствие макету',
                'process_steps' => [
                    ['key' => 'Передача макета', 'value' => 'Принимаем файлы AI, CDR, DXF, PDF с векторными контурами. Растровые изображения предварительно переводим в вектор.'],
                    ['key' => 'Технологическая проверка', 'value' => 'Оцениваем толщину материала, сложность контура, рассчитываем стоимость и срок.'],
                    ['key' => 'Раскрой', 'value' => 'Запускаем файл на лазерный станок. Процесс полностью автоматизирован, результат точно воспроизводит цифровой макет.'],
                    ['key' => 'Контроль и упаковка', 'value' => 'Проверяем геометрию деталей, убираем защитную плёнку (при необходимости), упаковываем для передачи или доставки.'],
                ],
            ],

            [
                'title' => 'Интерьерная печать',
                'excerpt' => 'Высококачественная широкоформатная интерьерная печать для оформления помещений.',
                'content' => <<<'HTML'
<p>Интерьерная печать — широкоформатная цифровая печать на самоклеящихся плёнках, баннере, фотобумаге и холсте для оформления внутренних пространств. Применяется в офисах, магазинах, ресторанах, выставочных стендах и жилых интерьерах.</p>

<h2>Виды интерьерной печати</h2>
<ul>
  <li><strong>Печать на самоклеящейся плёнке</strong> — для оклейки стен, витрин, колонн. Снимается без следов.</li>
  <li><strong>Печать на баннерной ткани</strong> — стенды, перегородки, растяжки внутри помещений.</li>
  <li><strong>Фотообои</strong> — панорамная печать на специальных интерьерных материалах.</li>
  <li><strong>Печать на холсте</strong> — картины и арт-объекты для декора стен.</li>
  <li><strong>Печать на фотобумаге</strong> — фотографии и постеры в рамки.</li>
</ul>

<h2>Применение</h2>
<p>Интерьерная печать востребована для брендирования корпоративных офисов, оформления торговых залов и витрин, создания выставочных стендов и стоек, декорирования гостиниц, ресторанов и общественных пространств, изготовления навигационных схем и информационных плакатов.</p>

<h2>Технические характеристики</h2>
<table>
  <thead>
    <tr><th>Параметр</th><th>Значение</th></tr>
  </thead>
  <tbody>
    <tr><td>Максимальная ширина печати</td><td>до 3 200 мм</td></tr>
    <tr><td>Разрешение</td><td>720–1440 dpi</td></tr>
    <tr><td>Материалы</td><td>плёнка, баннер, холст, фотобумага</td></tr>
    <tr><td>Ламинирование</td><td>матовое / глянцевое / текстурное</td></tr>
  </tbody>
</table>

<h2>Стоимость</h2>
<table>
  <thead>
    <tr><th>Материал</th><th>Стоимость, руб./м²</th></tr>
  </thead>
  <tbody>
    <tr><td>Самоклеящаяся плёнка</td><td>от 1 200</td></tr>
    <tr><td>Баннерная ткань</td><td>от 900</td></tr>
    <tr><td>Холст</td><td>от 1 800</td></tr>
    <tr><td>Фотобумага</td><td>от 1 500</td></tr>
  </tbody>
</table>
HTML,
                'price_from' => 1200,
                'preview' => 'interernaya-pechat.webp',
                'sort' => 40,
                'properties' => [
                    ['key' => 'Максимальная ширина', 'value' => 'до 3 200 мм'],
                    ['key' => 'Разрешение', 'value' => '720–1440 dpi'],
                    ['key' => 'Материалы', 'value' => 'плёнка, баннер, холст, фотобумага'],
                    ['key' => 'Ламинирование', 'value' => 'матовое, глянцевое, текстурное'],
                    ['key' => 'Срок выполнения', 'value' => 'от 1 рабочего дня'],
                ],
                'guarantee' => '2 года (устойчивость красок)',
                'process_steps' => [
                    ['key' => 'Передача макета', 'value' => 'Принимаем файлы в форматах PDF, AI, PSD, TIFF с разрешением от 100 dpi в масштабе 1:1 или от 300 dpi при уменьшенном масштабе.'],
                    ['key' => 'Согласование цвета', 'value' => 'По запросу изготавливаем цветопробу на выбранном материале для утверждения цветовой гаммы до запуска тиража.'],
                    ['key' => 'Печать', 'value' => 'Выполняем печать на профессиональном широкоформатном оборудовании. Контролируем плотность и однородность заливки.'],
                    ['key' => 'Постобработка', 'value' => 'При необходимости наносим ламинат, выполняем порезку по размеру, подготавливаем к монтажу.'],
                    ['key' => 'Выдача', 'value' => 'Передаём готовую продукцию в рулонах или на жёстком основании. Возможна доставка и монтаж.'],
                ],
            ],

            [
                'title' => 'УФ-печать',
                'excerpt' => 'Прямая УФ-печать на пластике, стекле, дереве, металле и композите.',
                'content' => <<<'HTML'
<p>УФ-печать — технология прямого нанесения изображения на поверхность материала с мгновенной полимеризацией краски ультрафиолетовой лампой. Не требует нанесения краски через промежуточный носитель: печать осуществляется непосредственно на готовой детали или панели.</p>

<h2>Преимущества УФ-печати</h2>
<ul>
  <li>Печать на жёстких поверхностях без предварительной подготовки</li>
  <li>Высокая устойчивость к выцветанию, влаге, механическим воздействиям</li>
  <li>Возможность объёмной (рельефной) печати за счёт многослойного нанесения</li>
  <li>Нет ограничений по форме — печатаем на готовых изделиях</li>
  <li>Экологически безопасные чернила без резкого запаха</li>
</ul>

<h2>Материалы для УФ-печати</h2>
<ul>
  <li>Акрил, ПВХ, полистирол</li>
  <li>Стекло и зеркала</li>
  <li>Алюминий, нержавеющая сталь</li>
  <li>Композитные панели</li>
  <li>МДФ, фанера, натуральное дерево</li>
  <li>Керамическая плитка, камень</li>
  <li>Кожа и кожзаменитель</li>
</ul>

<h2>Применение</h2>
<p>УФ-печать применяется для изготовления рекламных табличек и вывесок, сувенирной продукции (кружки, телефоны — на специальном оборудовании), интерьерных панно и декора, брендирования корпоративных изделий, печати на готовых компонентах конструкций.</p>

<h2>Стоимость УФ-печати</h2>
<table>
  <thead>
    <tr><th>Параметр</th><th>Стоимость</th></tr>
  </thead>
  <tbody>
    <tr><td>Печать на плоских материалах</td><td>от 2 500 руб./м²</td></tr>
    <tr><td>Рельефная (объёмная) печать</td><td>от 4 000 руб./м²</td></tr>
    <tr><td>Минимальный заказ</td><td>2 500 руб.</td></tr>
  </tbody>
</table>
HTML,
                'price_from' => 2500,
                'preview' => 'uf-pechat.webp',
                'sort' => 50,
                'properties' => [
                    ['key' => 'Максимальный размер', 'value' => 'до 2500 × 1250 мм'],
                    ['key' => 'Разрешение', 'value' => 'до 1440 dpi'],
                    ['key' => 'Материалы', 'value' => 'акрил, стекло, металл, дерево, МДФ, композит, керамика'],
                    ['key' => 'Рельефная печать', 'value' => 'доступна'],
                    ['key' => 'Срок выполнения', 'value' => 'от 1 рабочего дня'],
                ],
                'guarantee' => '3 года (стойкость изображения)',
                'process_steps' => [
                    ['key' => 'Подготовка макета', 'value' => 'Принимаем файлы PDF, AI, PSD, TIFF. При необходимости адаптируем макет под технологию УФ-печати.'],
                    ['key' => 'Подготовка основания', 'value' => 'Материал очищается и при необходимости грунтуется для обеспечения адгезии краски.'],
                    ['key' => 'Печать', 'value' => 'Наносим изображение послойно с мгновенной фиксацией каждого слоя UV-лампой.'],
                    ['key' => 'Контроль', 'value' => 'Проверяем яркость, чёткость, равномерность нанесения краски. Оцениваем сцепление по тест-полоске.'],
                    ['key' => 'Упаковка и выдача', 'value' => 'Упаковываем готовое изделие, чтобы исключить царапины при транспортировке. Передаём заказчику или отправляем доставкой.'],
                ],
            ],

            [
                'title' => 'Плоттерная резка',
                'excerpt' => 'Плоттерная резка плёнок для наклеек, трафаретов и брендирования.',
                'content' => <<<'HTML'
<p>Плоттерная резка — процесс вырезания изображений, текста или контуров из самоклеящейся плёнки, рефлектива или флока с помощью режущего плоттера. Нож следует по цифровому контуру, не оставляя следов на подложке. Это самый экономичный способ изготовления виниловых наклеек, трафаретов и декора.</p>

<h2>Где применяется плоттерная резка</h2>
<ul>
  <li>Наклейки на автомобили, стёкла, витрины</li>
  <li>Брендирование корпоративного транспорта</li>
  <li>Оконный декор и логотипы на стёклах</li>
  <li>Трафареты для покраски</li>
  <li>Интерьерные надписи и декоративные элементы на стенах</li>
  <li>Ценники и стикеры для товаров</li>
</ul>

<h2>Материалы</h2>
<ul>
  <li>Самоклеящаяся виниловая плёнка (матовая, глянцевая, цветная)</li>
  <li>Рефлективная (световозвращающая) плёнка</li>
  <li>Флок и бархатная плёнка</li>
  <li>Магнитный материал</li>
  <li>Пескоструйная (матирующая) плёнка для стекла</li>
</ul>

<h2>Стоимость плоттерной резки</h2>
<table>
  <thead>
    <tr><th>Тип работ</th><th>Стоимость</th></tr>
  </thead>
  <tbody>
    <tr><td>Резка простых контуров (до 5 элементов)</td><td>от 300 руб.</td></tr>
    <tr><td>Резка сложных контуров, надписи</td><td>от 1 500 руб./м²</td></tr>
    <tr><td>Монтажные комплекты с ламинатом</td><td>от 2 000 руб./м²</td></tr>
    <tr><td>Минимальный заказ</td><td>500 руб.</td></tr>
  </tbody>
</table>
HTML,
                'price_from' => 1500,
                'preview' => 'plotternaya-rezka.webp',
                'sort' => 60,
                'properties' => [
                    ['key' => 'Максимальная ширина', 'value' => 'до 1 600 мм'],
                    ['key' => 'Точность реза', 'value' => '±0,1 мм'],
                    ['key' => 'Материалы', 'value' => 'виниловая плёнка, рефлектив, флок, магнит, пескоструйная плёнка'],
                    ['key' => 'Минимальный заказ', 'value' => '500 руб.'],
                    ['key' => 'Срок выполнения', 'value' => 'от 1 рабочего дня'],
                ],
                'guarantee' => 'до 5 лет (зависит от материала и условий эксплуатации)',
                'process_steps' => [
                    ['key' => 'Передача макета', 'value' => 'Передаёте файл с контурами в AI, CDR или DXF. Растровый логотип переведём в вектор.'],
                    ['key' => 'Выбор материала', 'value' => 'Вместе выбираем подходящую плёнку: цвет, поверхность, стойкость к условиям эксплуатации.'],
                    ['key' => 'Резка', 'value' => 'Плоттер вырезает контуры с точностью до 0,1 мм. Производительность — до нескольких десятков метров в смену.'],
                    ['key' => 'Выборка фона', 'value' => 'Оператор убирает лишние части плёнки, оставляя только нужный рисунок или текст.'],
                    ['key' => 'Нанесение монтажной плёнки', 'value' => 'Поверх наклейки кладём монтажную плёнку для удобной переноски и аппликации.'],
                    ['key' => 'Выдача или монтаж', 'value' => 'Передаём готовые наклейки или выполняем монтаж на объекте нашими специалистами.'],
                ],
            ],

            [
                'title' => 'Дизайн и проектирование',
                'excerpt' => 'Разработка дизайна рекламных конструкций, 3D-визуализация и проектная документация.',
                'content' => <<<'HTML'
<p>Разработка дизайна — начальный и один из важнейших этапов создания рекламных конструкций. Качественный дизайн позволяет оценить результат ещё до начала производства, избежать ошибок и согласовать вывеску с требованиями администрации. Наши дизайнеры разрабатывают решения с учётом фирменного стиля, архитектуры фасада и задач бизнеса.</p>

<h2>Что входит в услугу</h2>
<ul>
  <li><strong>Концепция и эскиз</strong> — разработка общей идеи, формата, цветового решения.</li>
  <li><strong>Визуализация на фасаде</strong> — монтаж макета вывески на фотографию здания, чтобы вы видели итог до изготовления.</li>
  <li><strong>3D-моделирование</strong> — объёмная модель конструкции с разных ракурсов для сложных проектов.</li>
  <li><strong>Конструктивные чертежи</strong> — технические чертежи для производства: размеры, сечения, узлы крепления.</li>
  <li><strong>Согласовательная документация</strong> — подготовка пакета документов для получения разрешения на установку.</li>
</ul>

<h2>Форматы файлов</h2>
<p>Финальные макеты передаются в форматах AI, PDF, CDR, DWG. Все размеры указываются в масштабе 1:1. Исходники остаются у заказчика.</p>

<h2>Стоимость</h2>
<table>
  <thead>
    <tr><th>Вид работ</th><th>Стоимость</th></tr>
  </thead>
  <tbody>
    <tr><td>Визуализация на фасаде (до 2 вариантов)</td><td>от 2 000 руб.</td></tr>
    <tr><td>3D-моделирование конструкции</td><td>от 5 000 руб.</td></tr>
    <tr><td>Конструктивные чертежи</td><td>от 3 000 руб.</td></tr>
    <tr><td>Согласовательный пакет документов</td><td>от 5 000 руб.</td></tr>
  </tbody>
</table>
<p>При заказе производства вывески дизайн и визуализация — бесплатно.</p>
HTML,
                'price_from' => null,
                'preview' => 'dizayn-i-proektirovanie.webp',
                'sort' => 70,
                'properties' => [
                    ['key' => 'Количество вариантов дизайна', 'value' => 'до 3 вариантов'],
                    ['key' => 'Количество правок', 'value' => 'без ограничений до согласования'],
                    ['key' => 'Форматы файлов', 'value' => 'AI, PDF, CDR, DWG'],
                    ['key' => 'Визуализация на фасаде', 'value' => 'входит в стоимость при заказе производства'],
                    ['key' => 'Срок разработки', 'value' => 'от 1 рабочего дня'],
                ],
                'guarantee' => 'правки до полного согласования',
                'process_steps' => [
                    ['key' => 'Бриф', 'value' => 'Заполняете бриф или рассказываете о задаче: сфера бизнеса, фирменные цвета, пожелания по стилю, размер конструкции.'],
                    ['key' => 'Фото фасада', 'value' => 'Присылаете фото фасада в хорошем качестве или мы выезжаем на замер и фотографирование объекта.'],
                    ['key' => 'Разработка концепции', 'value' => 'Дизайнер готовит 1–3 варианта концепции и визуализирует их на фото фасада. Срок — 1–2 рабочих дня.'],
                    ['key' => 'Правки и согласование', 'value' => 'Вносим правки до утверждения финального варианта. Количество итераций не ограничено.'],
                    ['key' => 'Конструктивная документация', 'value' => 'После утверждения дизайна готовим чертежи для производства или согласовательный пакет для администрации.'],
                ],
            ],

            [
                'title' => 'Сварочные работы',
                'excerpt' => 'Сварочные работы при производстве металлоконструкций для наружной рекламы.',
                'content' => <<<'HTML'
<p>Сварочные работы — неотъемлемая часть производства рекламных металлоконструкций: пилонов, стел, каркасов вывесок, кронштейнов и несущих элементов. Собственный сварочный цех позволяет нам полностью контролировать качество сварных швов и соблюдать требования по несущей способности конструкций.</p>

<h2>Виды сварочных работ</h2>
<ul>
  <li><strong>MIG/MAG-сварка</strong> — основной метод для конструкционной стали. Высокая производительность, надёжный шов.</li>
  <li><strong>TIG-сварка</strong> — для нержавеющей стали и алюминия. Чистый шов без брызг, подходит для видимых элементов.</li>
  <li><strong>Сварка труб и профилей</strong> — несущие рамы, стойки, опоры пилонов.</li>
  <li><strong>Прихватки и сборка</strong> — сборка сложных пространственных конструкций по чертежам.</li>
</ul>

<h2>Материалы</h2>
<ul>
  <li>Конструкционная сталь (Ст3, Ст20)</li>
  <li>Нержавеющая сталь (AISI 304, 316)</li>
  <li>Алюминиевые сплавы</li>
  <li>Профильные трубы: круглые, квадратные, прямоугольные</li>
</ul>

<h2>Где применяется</h2>
<p>Сварочные работы применяются при изготовлении несущих каркасов вывесок и световых коробов, стел и пилонов, кронштейнов для крепления рекламных конструкций к фасадам, заборных и ограждающих конструкций с рекламными панелями, уличной мебели с фирменной символикой.</p>

<h2>Контроль качества</h2>
<p>Все сварные швы осматриваются визуально. Несущие элементы дополнительно проверяются нагрузочным тестом. Соединения для уличного применения обязательно грунтуются и окрашиваются порошковой или жидкой краской.</p>
HTML,
                'price_from' => null,
                'preview' => 'svarochnye-raboty.webp',
                'sort' => 80,
                'properties' => [
                    ['key' => 'Виды сварки', 'value' => 'MIG/MAG, TIG'],
                    ['key' => 'Металлы', 'value' => 'конструкционная сталь, нержавейка, алюминий'],
                    ['key' => 'Антикоррозийная обработка', 'value' => 'грунтовка + порошковое окрашивание'],
                    ['key' => 'Работы по чертежам', 'value' => 'да, принимаем DWG, PDF'],
                    ['key' => 'Срок выполнения', 'value' => 'от 1 рабочего дня'],
                ],
                'guarantee' => '2 года на сварные швы',
                'process_steps' => [
                    ['key' => 'Чертежи и ТЗ', 'value' => 'Получаем чертежи или разрабатываем их самостоятельно по вашему эскизу. Уточняем требования к нагрузкам.'],
                    ['key' => 'Подбор материала', 'value' => 'Выбираем сталь, профиль и сварочный метод в зависимости от условий эксплуатации конструкции.'],
                    ['key' => 'Раскрой и подготовка', 'value' => 'Разрезаем профили, трубы и листы до нужных размеров. Зачищаем кромки для качественного сплавления.'],
                    ['key' => 'Сборка и сварка', 'value' => 'Собираем конструкцию по чертежу, провариваем швы. Контролируем геометрию на каждом этапе.'],
                    ['key' => 'Обработка и финиш', 'value' => 'Зачищаем швы, наносим грунт и антикоррозийное покрытие. При необходимости — порошковая покраска в нужный цвет по RAL.'],
                ],
            ],

            [
                'title' => 'Монтажные работы',
                'excerpt' => 'Профессиональный монтаж вывесок и рекламных конструкций любой сложности.',
                'content' => <<<'HTML'
<p>Монтаж — завершающий и один из самых ответственных этапов реализации рекламного проекта. Неправильно установленная конструкция не только выглядит неаккуратно, но и может быть опасна. Наша монтажная бригада имеет допуск к работам на высоте, оснащена необходимым оборудованием и строго соблюдает нормы безопасности.</p>

<h2>Виды монтажных работ</h2>
<ul>
  <li><strong>Монтаж вывесок и световых коробов</strong> на фасады зданий, включая кирпич, бетон, стекло, композит.</li>
  <li><strong>Монтаж объёмных букв</strong> — крепление на шпильки, кронштейны, разделители к стене или коробу.</li>
  <li><strong>Установка пилонов и стел</strong> — бетонирование основания, монтаж несущей конструкции и лицевых панелей.</li>
  <li><strong>Монтаж баннеров и натяжных конструкций</strong> — флагштоки, баннерные рамы.</li>
  <li><strong>Демонтаж старых конструкций</strong> — аккуратный снос без повреждений фасада.</li>
  <li><strong>Подключение подсветки</strong> — прокладка кабеля, подключение блоков питания, проверка.</li>
</ul>

<h2>Оборудование и допуски</h2>
<p>Работаем с автовышкой, фасадными лесами и промышленными альпинистами. Все монтажники имеют удостоверения по охране труда и допуски к высотным работам. Перед началом монтажа согласовываем с заказчиком схему крепления и точки сверления.</p>

<h2>Стоимость монтажа</h2>
<table>
  <thead>
    <tr><th>Вид работ</th><th>Стоимость от</th></tr>
  </thead>
  <tbody>
    <tr><td>Монтаж вывески / светового короба</td><td>от 5 000 руб.</td></tr>
    <tr><td>Монтаж объёмных букв (до 10 шт.)</td><td>от 3 000 руб.</td></tr>
    <tr><td>Установка пилона / стелы</td><td>от 15 000 руб.</td></tr>
    <tr><td>Демонтаж конструкций</td><td>от 2 000 руб.</td></tr>
    <tr><td>Подъём автовышкой (выезд)</td><td>от 5 000 руб.</td></tr>
  </tbody>
</table>
HTML,
                'price_from' => 5000,
                'preview' => 'montazhnye-raboty.webp',
                'sort' => 90,
                'properties' => [
                    ['key' => 'Допуск к высотным работам', 'value' => 'есть у всех монтажников'],
                    ['key' => 'Техника', 'value' => 'автовышка, леса, промышленный альпинизм'],
                    ['key' => 'Виды фасадов', 'value' => 'кирпич, бетон, стекло, металл, композит'],
                    ['key' => 'Подключение электрики', 'value' => 'входит в стоимость монтажа'],
                    ['key' => 'Акт приёма-передачи', 'value' => 'оформляется по завершении работ'],
                ],
                'guarantee' => '1 год на монтаж',
                'process_steps' => [
                    ['key' => 'Согласование', 'value' => 'Менеджер уточняет адрес, тип фасада, наличие электроточки, этаж установки и предполагаемую дату монтажа.'],
                    ['key' => 'Выезд на замер', 'value' => 'Монтажник осматривает фасад, определяет способ крепления и необходимую технику (вышка, леса, альпинизм).'],
                    ['key' => 'Согласование схемы крепления', 'value' => 'Составляем схему монтажа, согласовываем точки сверления с заказчиком.'],
                    ['key' => 'Монтаж', 'value' => 'Устанавливаем конструкцию, подключаем электрику, проверяем работу всех световых элементов.'],
                    ['key' => 'Сдача объекта', 'value' => 'Подписываем акт, передаём гарантийный талон. Вывозим строительный мусор и остатки материалов.'],
                ],
            ],

            [
                'title' => 'Обшивка фасадов',
                'excerpt' => 'Обшивка и облицовка фасадов композитными панелями и другими материалами.',
                'content' => <<<'HTML'
<p>Обшивка фасадов — комплексная услуга по облицовке зданий листовыми материалами. Позволяет кардинально обновить внешний вид объекта, создать фирменный стиль, улучшить теплоизоляцию и защитить стены от атмосферных воздействий. Обшивка также используется как основа под монтаж вывесок и рекламных конструкций.</p>

<h2>Материалы для обшивки</h2>
<ul>
  <li><strong>Алюминиевые композитные панели (алюкобонд)</strong> — наиболее популярный материал. Лёгкие, долговечные, легко поддаются резке и гибке. Широкая палитра цветов и фактур.</li>
  <li><strong>HPL-панели</strong> — высококачественный ламинат с имитацией дерева, камня, металла. Устойчивы к УФ и механическим воздействиям.</li>
  <li><strong>Профлист и металлокассеты</strong> — экономичный вариант для производственных зданий.</li>
  <li><strong>Керамогранит на подконструкции</strong> — представительные фасады торговых центров и офисов.</li>
</ul>

<h2>Этапы работ</h2>
<p>Обшивка фасада включает монтаж несущей подконструкции из алюминиевого или стального профиля, укладку (при необходимости) теплоизоляции, крепление облицовочных панелей, устройство откосов, примыканий и водоотведения.</p>

<h2>Преимущества нашей компании</h2>
<ul>
  <li>Проводим все работы своими силами без субподрядчиков</li>
  <li>Разрабатываем раскладку панелей в цифровой модели до начала монтажа</li>
  <li>Делаем порезку панелей в цехе — ровные края, минимальные отходы</li>
  <li>Работаем на объектах любой высоты (автовышка, леса)</li>
</ul>

<h2>Стоимость</h2>
<p>Стоимость обшивки рассчитывается индивидуально в зависимости от площади, материала и сложности архитектуры фасада. Для точного расчёта необходим выезд специалиста на замер. Ориентировочная стоимость — от 3 000 руб./м² «под ключ» (материал + работа).</p>
HTML,
                'price_from' => null,
                'preview' => 'obshivka-fasadov.webp',
                'sort' => 100,
                'properties' => [
                    ['key' => 'Материалы', 'value' => 'алюкобонд, HPL, профлист, металлокассеты, керамогранит'],
                    ['key' => 'Подконструкция', 'value' => 'алюминиевый или стальной профиль'],
                    ['key' => 'Теплоизоляция', 'value' => 'возможна в составе системы'],
                    ['key' => 'Расчёт раскладки', 'value' => 'в цифровой модели до монтажа'],
                    ['key' => 'Срок работ', 'value' => 'от 3 рабочих дней (зависит от площади)'],
                ],
                'guarantee' => '5 лет на конструкцию и монтаж',
                'process_steps' => [
                    ['key' => 'Замер и обследование', 'value' => 'Специалист приезжает на объект, измеряет площадь фасада, фиксирует рельеф и особенности стен, оценивает состояние основания.'],
                    ['key' => 'Проект раскладки', 'value' => 'Разрабатываем раскладку панелей в масштабе: рассчитываем количество материала, учитываем проёмы, углы, примыкания.'],
                    ['key' => 'Коммерческое предложение', 'value' => 'Выставляем смету с разбивкой по материалам и работам. Срок — фиксированный в договоре.'],
                    ['key' => 'Монтаж подконструкции', 'value' => 'Устанавливаем несущие профили, анкеруем в стену, выводим плоскость фасада.'],
                    ['key' => 'Монтаж панелей', 'value' => 'Крепим облицовочные панели по раскладке, устраиваем примыкания, откосы, водоотводящие элементы.'],
                    ['key' => 'Сдача объекта', 'value' => 'Осматриваем фасад совместно с заказчиком, подписываем акт выполненных работ, передаём гарантию.'],
                ],
            ],

            [
                'title' => 'Сервисное обслуживание',
                'excerpt' => 'Техническое обслуживание, ремонт и замена элементов рекламных конструкций.',
                'content' => <<<'HTML'
<p>Рекламные конструкции требуют регулярного технического обслуживания: элементы подсветки со временем выходят из строя, лицевые поверхности требуют очистки, крепёж нуждается в ревизии. Мы оказываем полный спектр сервисных услуг для вывесок и наружной рекламы — как для конструкций нашего производства, так и для изготовленных другими компаниями.</p>

<h2>Виды сервисных работ</h2>
<ul>
  <li><strong>Диагностика</strong> — осмотр конструкции, выявление неисправностей подсветки, крепежа и корпуса.</li>
  <li><strong>Замена LED-модулей и ламп</strong> — восстановление равномерного свечения светового короба или букв.</li>
  <li><strong>Ремонт блоков питания и трансформаторов</strong> — замена неисправных электронных компонентов.</li>
  <li><strong>Замена лицевых материалов</strong> — новое акриловое стекло, баннерная ткань, плёнка.</li>
  <li><strong>Чистка и покраска</strong> — очистка от загрязнений, обновление антикоррозийного покрытия.</li>
  <li><strong>Ревизия крепежа</strong> — проверка затяжки анкеров и болтовых соединений, устранение люфтов.</li>
  <li><strong>Плановое ТО</strong> — комплексный осмотр по договору 1–2 раза в год.</li>
</ul>

<h2>Договор на сервисное обслуживание</h2>
<p>Для юридических лиц предлагаем заключить договор на плановое ТО. В рамках договора мы проводим регулярные осмотры и устраняем неисправности в приоритетном порядке. Фиксированная стоимость в год даёт предсказуемые расходы на обслуживание рекламы.</p>

<h2>Стоимость</h2>
<table>
  <thead>
    <tr><th>Услуга</th><th>Стоимость от</th></tr>
  </thead>
  <tbody>
    <tr><td>Диагностика (выезд)</td><td>от 1 000 руб.</td></tr>
    <tr><td>Замена LED-модулей (1 пог. м)</td><td>от 800 руб.</td></tr>
    <tr><td>Замена блока питания</td><td>от 2 000 руб.</td></tr>
    <tr><td>Замена лицевого акрила</td><td>от 3 000 руб.</td></tr>
    <tr><td>Плановое ТО (1 визит)</td><td>от 3 500 руб.</td></tr>
    <tr><td>Годовой договор ТО</td><td>от 12 000 руб./год</td></tr>
  </tbody>
</table>
HTML,
                'price_from' => null,
                'preview' => 'servisnoe-obsluzhivanie.webp',
                'sort' => 110,
                'properties' => [
                    ['key' => 'Выезд на диагностику', 'value' => 'в течение 1–2 рабочих дней'],
                    ['key' => 'Работаем с конструкциями', 'value' => 'любого производителя'],
                    ['key' => 'Договор на ТО', 'value' => 'доступен для юридических лиц'],
                    ['key' => 'Аварийный выезд', 'value' => 'в день обращения (дополнительно)'],
                    ['key' => 'Гарантия на замену компонентов', 'value' => '1 год'],
                ],
                'guarantee' => '1 год на выполненные работы и установленные компоненты',
                'process_steps' => [
                    ['key' => 'Обращение', 'value' => 'Сообщаете о неисправности по телефону или в мессенджере. Описываете проблему или прикладываете фото.'],
                    ['key' => 'Согласование выезда', 'value' => 'Менеджер согласовывает удобное время выезда мастера. Для плановых клиентов — приоритетный выезд.'],
                    ['key' => 'Диагностика', 'value' => 'Мастер осматривает конструкцию, выявляет все неисправности, составляет перечень работ и список необходимых материалов.'],
                    ['key' => 'Согласование и ремонт', 'value' => 'Согласовываем стоимость ремонта. После подтверждения — выполняем работы на месте или забираем конструкцию в цех.'],
                    ['key' => 'Проверка и сдача', 'value' => 'После ремонта проверяем работоспособность всех систем. Передаём акт выполненных работ и гарантийный документ.'],
                ],
            ],
        ];

        foreach ($services as $service) {
            $slug = SlugService::createSlug(Service::class, 'slug', $service['title']);
            $attachment = Attachment::where('original_name', $service['preview'])->first();

            if (! $attachment) {
                $this->command->warn("Изображение {$service['preview']} не найдено в базе аттачей");

                continue;
            }
            Service::create([
                'title' => $service['title'],
                'excerpt' => $service['excerpt'],
                'content' => $service['content'],
                'price_from' => $service['price_from'],
                'sort' => $service['sort'],
                'slug' => $slug,
                'active' => true,
                'process_steps' => $service['process_steps'],
                'properties' => $service['properties'],
                'guarantee' => $service['guarantee'],
                'preview_id' => $attachment->id,
                'detail_id' => $attachment->id,
                'published_at' => now(),
            ]);
        }
    }
}

```

### database/seeders/SettingSeeder.php

```php
<?php

// database/seeders/SettingSeeder.php

namespace Database\Seeders;

use App\Enums\SettingGroup;
use App\Enums\SettingType;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Orchid\Attachment\Models\Attachment;

class SettingSeeder extends Seeder
{
    /**
     * Получить ID аттачмента по его original_name
     */
    protected function getAttachmentId(string $originalName): ?int
    {
        $attachment = Attachment::where('original_name', $originalName)->first();

        return $attachment?->id;
    }

    public function run(): void
    {
        // Получаем ID созданных изображений
        $logoId = $this->getAttachmentId('logo.webp');
        $this->command->info($logoId ? "Найден ID для logo.webp: $logoId" : 'Не найден аттачмент для logo.webp');

        $logoDarkId = $this->getAttachmentId('logo-dark.webp');
        $this->command->info($logoDarkId ? "Найден ID для logo-dark.webp: $logoDarkId" : 'Не найден аттачмент для logo-dark.webp');

        $logoMobileId = $this->getAttachmentId('logo-mobile.webp');
        $this->command->info($logoMobileId ? "Найден ID для logo-mobile.webp: $logoMobileId" : 'Не найден аттачмент для logo-mobile.webp');

        $favicon32Id = $this->getAttachmentId('favicon-32x32.webp');
        $this->command->info($favicon32Id ? "Найден ID для favicon-32x32.webp: $favicon32Id" : 'Не найден аттачмент для favicon-32x32.webp');

        $appleTouchIconId = $this->getAttachmentId('apple-touch-icon.webp');
        $this->command->info($appleTouchIconId ? "Найден ID для apple-touch-icon.webp: $appleTouchIconId" : 'Не найден аттачмент для apple-touch-icon.webp');

        $androidChrome192Id = $this->getAttachmentId('android-chrome-192x192.webp');
        $this->command->info($androidChrome192Id ? "Найден ID для android-chrome-192x192.webp: $androidChrome192Id" : 'Не найден аттачмент для android-chrome-192x192.webp');

        $androidChrome512Id = $this->getAttachmentId('android-chrome-512x512.webp');
        $this->command->info($androidChrome512Id ? "Найден ID для android-chrome-512x512.webp: $androidChrome512Id" : 'Не найден аттачмент для android-chrome-512x512.webp');

        $faviconIcoId = $this->getAttachmentId('favicon.ico');
        $this->command->info($faviconIcoId ? "Найден ID для favicon.ico: $faviconIcoId" : 'Не найден аттачмент для favicon.ico');

        $favicon16Id = $this->getAttachmentId('favicon-16x16.webp');
        $this->command->info($favicon16Id ? "Найден ID для favicon-16x16.webp: $favicon16Id" : 'Не найден аттачмент для favicon-16x16.webp');

        $ogImageId = $this->getAttachmentId('og-image.webp');
        $this->command->info($ogImageId ? "Найден ID для og-image.webp: $ogImageId" : 'Не найден аттачмент для og-image.webp');

        $sitePreviewId = $this->getAttachmentId('site-preview.webp');
        $this->command->info($sitePreviewId ? "Найден ID для site-preview.webp: $sitePreviewId" : 'Не найден аттачмент для site-preview.webp');

        $decor1 = $this->getAttachmentId('decor1.webp');
        $this->command->info($decor1 ? "Найден ID для decor1.webp: $decor1" : 'Не найден аттачмент для decor1.webp');

        $decor2 = $this->getAttachmentId('decor2.webp');
        $this->command->info($decor2 ? "Найден ID для decor2.webp: $decor2" : 'Не найден аттачмент для decor2.webp');

        $decor3 = $this->getAttachmentId('decor3.webp');
        $this->command->info($decor3 ? "Найден ID для decor3.webp: $decor3" : 'Не найден аттачмент для decor3.webp');

        $decor4 = $this->getAttachmentId('decor4.webp');
        $this->command->info($decor4 ? "Найден ID для decor4.webp: $decor4" : 'Не найден аттачмент для decor4.webp');

        $bridge1 = $this->getAttachmentId('bridge1.webp');
        $this->command->info($bridge1 ? "Найден ID для bridge1.webp: $bridge1" : 'Не найден аттачмент для bridge1.webp');

        $bridge2 = $this->getAttachmentId('bridge2.webp');
        $this->command->info($bridge2 ? "Найден ID для bridge2.webp: $bridge2" : 'Не найден аттачмент для bridge2.webp');

        $bridge3 = $this->getAttachmentId('bridge3.webp');
        $this->command->info($bridge3 ? "Найден ID для bridge3.webp: $bridge3" : 'Не найден аттачмент для bridge3.webp');

        $bridge4 = $this->getAttachmentId('bridge4.webp');
        $this->command->info($bridge4 ? "Найден ID для bridge4.webp: $bridge4" : 'Не найден аттачмент для bridge4.webp');
        // Используем updateOrCreate вместо import, чтобы избежать проблемы с мета-данными
        $settings = [
            // Основные настройки
            [
                'key' => 'site_name',
                'value' => 'Нарратив',
                'type' => SettingType::STRING,
                'group' => SettingGroup::GENERAL,
                'description' => 'Название сайта',
            ],
            [
                'key' => 'site_description',
                'value' => 'Производство и установка наружной рекламы. Полный цикл от идеи до
                    реализации.',
                'type' => SettingType::STRING,
                'group' => SettingGroup::GENERAL,
                'description' => 'Описание сайта',
            ],
            [
                'key' => 'site_logo',
                'value' => $logoId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Логотип сайта',
            ],
            [
                'key' => 'site_logo_dark',
                'value' => $logoDarkId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Логотип для темного фона',
            ],
            [
                'key' => 'site_logo_mobile',
                'value' => $logoMobileId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Логотип для мобильной версии',
            ],
            [
                'key' => 'favicon_ico',
                'value' => $faviconIcoId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Favicon ICO (для старых браузеров)',
            ],
            [
                'key' => 'favicon_16',
                'value' => $favicon16Id,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Favicon 16x16 (WebP)',
            ],
            [
                'key' => 'favicon_32',
                'value' => $favicon32Id,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Favicon 32x32 (WebP)',
            ],
            [
                'key' => 'apple_touch_icon',
                'value' => $appleTouchIconId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Apple Touch Icon (для iPhone/iPad)',
            ],
            [
                'key' => 'android_chrome_192',
                'value' => $androidChrome192Id,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Android Chrome 192x192',
            ],
            [
                'key' => 'android_chrome_512',
                'value' => $androidChrome512Id,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Android Chrome 512x512',
            ],

            // Open Graph изображения
            [
                'key' => 'og_image',
                'value' => $ogImageId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::SEO,
                'description' => 'Open Graph изображение (для соцсетей)',
            ],
            [
                'key' => 'site_preview',
                'value' => $sitePreviewId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::SEO,
                'description' => 'Site Preview изображение (альтернативное)',
            ],
            [
                'key' => 'maintenance_mode',
                'value' => false,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::GENERAL,
                'description' => 'Режим обслуживания',
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'Сайт временно недоступен, ведутся технические работы',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::GENERAL,
                'description' => 'Сообщение в режиме обслуживания',
            ],
            // Изображения для декора
            [
                'key' => 'decor1',
                'value' => $decor1,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в блоках без картинок на фоне',
            ],
            [
                'key' => 'decor2',
                'value' => $decor2,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в блоках без картинок на фоне',
            ],
            [
                'key' => 'decor3',
                'value' => $decor3,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в футере на фоне',
            ],
            [
                'key' => 'decor4',
                'value' => $decor4,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в футере на фоне',
            ],
            [
                'key' => 'bridge1',
                'value' => $bridge1,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в блоках без картинок на фоне',
            ],
            [
                'key' => 'bridge2',
                'value' => $bridge2,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в блоках без картинок на фоне',
            ],
            [
                'key' => 'bridge3',
                'value' => $bridge3,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в футере на фоне',
            ],
            [
                'key' => 'bridge4',
                'value' => $bridge4,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в футере на фоне',
            ],
            // Контакты
            [
                'key' => 'contact_phone',
                'value' => '+7 (999) 123-45-67',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Основной телефон',
            ],
            [
                'key' => 'contact_phone_2',
                'value' => '+7 (999) 765-43-21',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Дополнительный телефон',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@narrative.ru',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Email для связи',
            ],
            [
                'key' => 'contact_address',
                'value' => 'г. Москва, ул. Примерная, д. 123',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Адрес офиса/производства',
            ],
            // КООРДИНАТЫ ДЛЯ КАРТЫ
            [
                'key' => 'map_latitude',
                'value' => '55.7558',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Широта для карты (Yandex/Google)',
            ],
            [
                'key' => 'map_longitude',
                'value' => '37.6176',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Долгота для карты (Yandex/Google)',
            ],
            [
                'key' => 'map_zoom',
                'value' => 17,
                'type' => SettingType::INTEGER,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Уровень приближения карты',
            ],
            [
                'key' => 'map_placemark_title',
                'value' => 'Нарратив - Производство рекламы',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Название метки на карте',
            ],
            [
                'key' => 'map_placemark_body',
                'value' => 'Производство и монтаж наружной рекламы<br>Режим работы: Пн-Пт 9:00-18:00',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Описание в метке карты',
            ],
            [
                'key' => 'map_api_key_yandex',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'API ключ для Яндекс.Карт',
            ],
            [
                'key' => 'map_api_key_google',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'API ключ для Google Maps',
            ],
            [
                'key' => 'working_hours',
                'value' => 'Пн-Пт: 9:00 - 18:00, Сб-Вс: выходной',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Режим работы',
            ],
            [
                'key' => 'how_to_get_text',
                'value' => 'На метро: ст. м. Текстильщики (выход №3), далее 5 минут пешком или автобус №193 до остановки «Производственная улица».<br>На автомобиле: со стороны МКАД (Каширское шоссе), въезд на территорию по пропуску.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Текст "Как добраться"',
            ],
            // Реквизиты компании
            [
                'key' => 'company_name',
                'value' => 'ООО «Нарратив»',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Полное наименование компании',
            ],
            [
                'key' => 'company_inn',
                'value' => '7712345678',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'ИНН',
            ],
            [
                'key' => 'company_kpp',
                'value' => '771201001',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'КПП',
            ],
            [
                'key' => 'company_ogrn',
                'value' => '1127746123456',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'ОГРН',
            ],
            [
                'key' => 'company_bank_account',
                'value' => '40702810123450101234',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Расчётный счёт',
            ],
            [
                'key' => 'company_bank_name',
                'value' => 'АО «Сбербанк России»',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Название банка',
            ],
            [
                'key' => 'company_bank_bik',
                'value' => '044525225',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'БИК банка',
            ],
            [
                'key' => 'company_correspondent_account',
                'value' => '30101810400000000225',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Корреспондентский счёт',
            ],
            // Социальные сети
            [
                'key' => 'social_vk',
                'value' => 'https://vk.com/narrative',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'ВКонтакте',
            ],
            [
                'key' => 'social_telegram',
                'value' => 'https://t.me/narrative',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'Telegram канал',
            ],
            [
                'key' => 'social_whatsapp',
                'value' => 'https://wa.me/79991234567',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'WhatsApp',
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/narrative',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'Instagram',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@narrative',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'YouTube канал',
            ],
            [
                'key' => 'social_viber',
                'value' => 'viber://chat?number=%2B79991234567',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'Viber',
            ],
            // SEO - расширенные настройки
            [
                'key' => 'seo_default_title',
                'value' => 'Нарратив - Производство и монтаж наружной рекламы в Москве',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SEO,
                'description' => 'SEO заголовок по умолчанию',
            ],
            [
                'key' => 'seo_default_description',
                'value' => 'Профессиональное производство и монтаж наружной рекламы в Москве. Широкий выбор материалов, собственное производство, опытные монтажники.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'SEO описание по умолчанию',
            ],
            [
                'key' => 'seo_default_keywords',
                'value' => 'наружная реклама, производство рекламы, монтаж рекламы, вывески, рекламные щиты, Москва',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'SEO ключевые слова по умолчанию',
            ],
            [
                'key' => 'seo_og_image',
                'value' => $ogImageId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::SEO,
                'description' => 'Изображение для Open Graph (соцсети)',
            ],
            [
                'key' => 'seo_robots_txt',
                'value' => "User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: https://narrative.ru/sitemap.xml",
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Содержимое robots.txt',
            ],
            [
                'key' => 'seo_yandex_verification',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SEO,
                'description' => 'Код верификации Яндекс',
            ],
            [
                'key' => 'seo_google_verification',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SEO,
                'description' => 'Код верификации Google',
            ],
            [
                'key' => 'seo_metrika_counter',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Код счетчика Яндекс.Метрики',
            ],
            [
                'key' => 'seo_analytics_counter',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Код счетчика Google Analytics',
            ],
            [
                'key' => 'seo_meta_tags',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Дополнительные meta-теги (в head)',
            ],
            [
                'key' => 'seo_scripts_body_start',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Скрипты после открытия body',
            ],
            [
                'key' => 'seo_scripts_body_end',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Скрипты перед закрытием body',
            ],
            // Telegram - расширенные
            [
                'key' => 'telegram_bot_token',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Токен Telegram бота',
            ],
            [
                'key' => 'telegram_chat_id',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'ID чата для уведомлений',
            ],
            [
                'key' => 'telegram_notifications_enabled',
                'value' => true,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Включить уведомления в Telegram',
            ],
            [
                'key' => 'telegram_notify_new_order',
                'value' => true,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Уведомлять о новых заказах',
            ],
            [
                'key' => 'telegram_notify_new_feedback',
                'value' => true,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Уведомлять о новых сообщениях из форм',
            ],
            [
                'key' => 'telegram_notify_new_user',
                'value' => false,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Уведомлять о регистрации новых пользователей',
            ],
            // Email
            [
                'key' => 'email_notifications_enabled',
                'value' => true,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::EMAIL,
                'description' => 'Включить email-уведомления',
            ],
            [
                'key' => 'email_admin',
                'value' => 'admin@narrative.ru',
                'type' => SettingType::STRING,
                'group' => SettingGroup::EMAIL,
                'description' => 'Email для получения уведомлений',
            ],
            [
                'key' => 'email_sales',
                'value' => 'sales@narrative.ru',
                'type' => SettingType::STRING,
                'group' => SettingGroup::EMAIL,
                'description' => 'Email для заказов',
            ],
            [
                'key' => 'email_support',
                'value' => 'support@narrative.ru',
                'type' => SettingType::STRING,
                'group' => SettingGroup::EMAIL,
                'description' => 'Email техподдержки',
            ],
            [
                'key' => 'email_from_name',
                'value' => 'Нарратив',
                'type' => SettingType::STRING,
                'group' => SettingGroup::EMAIL,
                'description' => 'Имя отправителя писем',
            ],
            [
                'key' => 'email_signature',
                'value' => 'С уважением, команда "Нарратив"',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::EMAIL,
                'description' => 'Подпись в письмах',
            ],
            // Дизайн и внешний вид
            [
                'key' => 'theme_primary_color',
                'value' => '#3B82F6',
                'type' => SettingType::COLOR,
                'group' => SettingGroup::DESIGN,
                'description' => 'Основной цвет',
            ],
            [
                'key' => 'theme_secondary_color',
                'value' => '#10B981',
                'type' => SettingType::COLOR,
                'group' => SettingGroup::DESIGN,
                'description' => 'Вторичный цвет',
            ],
            [
                'key' => 'theme_font_family',
                'value' => 'Inter, sans-serif',
                'type' => SettingType::STRING,
                'group' => SettingGroup::DESIGN,
                'description' => 'Основной шрифт',
            ],
            [
                'key' => 'custom_css',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::DESIGN,
                'description' => 'Пользовательский CSS',
            ],
            // Уведомления
            [
                'key' => 'notification_position',
                'value' => 'bottom-right',
                'type' => SettingType::STRING,
                'group' => SettingGroup::NOTIFICATIONS,
                'description' => 'Позиция всплывающих уведомлений',
            ],
            [
                'key' => 'notification_duration',
                'value' => 5000,
                'type' => SettingType::INTEGER,
                'group' => SettingGroup::NOTIFICATIONS,
                'description' => 'Длительность показа уведомлений (мс)',
            ],
            // контент страниц
            [
                'key' => 'about.hero.label',
                'value' => 'Кто мы такие',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "О компании"',
            ],
            [
                'key' => 'about.hero.title',
                'value' => 'О компании Нарратив',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "О компании"',
            ],
            [
                'key' => 'about.hero.subtitle',
                'value' => 'Производим наружную и интерьерную рекламу с 2010 года. За это время реализовали более 500 проектов для малого бизнеса и крупных сетей.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "О компании"',
            ],
            [
                'key' => 'about.advantages.label',
                'value' => 'Почему выбирают нас',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл секции преимуществ',
            ],
            [
                'key' => 'about.advantages.title',
                'value' => 'Наши преимущества',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок секции преимуществ',
            ],
            [
                'key' => 'about.partners.label',
                'value' => 'Наши партнёры',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл секции партнёров',
            ],
            [
                'key' => 'about.partners.title',
                'value' => 'Кто с нами работает',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок секции партнёров',
            ],
            [
                'key' => 'about.equipment.label',
                'value' => 'Наше производство',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл секции оборудования',
            ],
            [
                'key' => 'about.equipment.title',
                'value' => 'Оборудование',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок секции оборудования',
            ],
            [
                'key' => 'about.equipment.subtitle',
                'value' => 'Собственный цех оснащён современным оборудованием ведущих мировых брендов.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок секции оборудования',
            ],
            [
                'key' => 'about.equipment.button_all',
                'value' => 'Всё оборудование',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Текст кнопки "Всё оборудование" на превью',
            ],
            [
                'key' => 'about.portfolio.label',
                'value' => 'Наши работы',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл секции портфолио',
            ],
            [
                'key' => 'about.portfolio.title',
                'value' => 'Лучшие проекты',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок секции портфолио',
            ],
            [
                'key' => 'about.portfolio.button_all',
                'value' => 'Смотреть все проекты',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Текст кнопки "Смотреть все проекты"',
            ],
            [
                'key' => 'about.cta.label',
                'value' => 'Готовы к сотрудничеству',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл CTA-блока',
            ],
            [
                'key' => 'about.cta.title',
                'value' => 'Обсудим ваш проект?',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок CTA-блока',
            ],
            [
                'key' => 'about.cta.subtitle',
                'value' => 'Расскажите нам о вашем бизнесе и задачах — мы предложим лучшее решение и просчитаем смету.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок CTA-блока',
            ],
            [
                'key' => 'about.cta.btn_call',
                'value' => 'Заказать звонок',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Текст кнопки "Заказать звонок"',
            ],
            [
                'key' => 'about.cta.btn_write',
                'value' => 'Написать нам',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Текст кнопки "Написать нам"',
            ],
            [
                'key' => 'about.intro.btn_catalog',
                'value' => 'Каталог продукции',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Кнопка "Каталог продукции" в intro-блоке',
            ],
            [
                'key' => 'about.intro.btn_contacts',
                'value' => 'Связаться с нами',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Кнопка "Связаться с нами" в intro-блоке',
            ],
            [
                'key' => 'equipment.hero.label',
                'value' => 'Наш цех',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.hero.title',
                'value' => 'Оборудование и технологии',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.hero.subtitle',
                'value' => 'Производственная база площадью 800 м² с современными станками ведущих мировых
                брендов. Всё оборудование — собственное, без субподряда.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.main.label',
                'value' => 'Парк станков',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в главном блоке страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.main.title',
                'value' => 'Фрезерное и лазерное оборудование',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок главном блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.technology.label',
                'value' => 'Технологические возможности',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в блоке технологий страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.technology.title',
                'value' => 'Что мы умеем делать',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок блока технологий страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.material.label',
                'value' => 'Сырьё и расходники',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в блоке материалов страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.material.title',
                'value' => 'Материалы, с которыми мы работаем',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок блока материалов страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'blog.hero.label',
                'value' => 'Экспертный контент',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'blog.hero.title',
                'value' => 'Блог о рекламе и производстве',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'blog.hero.subtitle',
                'value' => 'Рассказываем о технологиях, материалах, дизайне и практических кейсах из нашей работы.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'faq.hero.label',
                'value' => 'Частые вопросы',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "FAQ"',
            ],
            [
                'key' => 'faq.hero.title',
                'value' => 'Всё, что вы хотели узнать',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "FAQ"',
            ],
            [
                'key' => 'faq.hero.subtitle',
                'value' => 'Собрали ответы на 30+ вопросов о производстве, ценах, сроках, монтаже и гарантии.
                Не нашли своё — спросите напрямую.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "FAQ"',
            ],
            [
                'key' => 'contacts.hero.label',
                'value' => 'Свяжитесь с нами',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Контакты"',
            ],
            [
                'key' => 'contacts.hero.title',
                'value' => 'Контакты',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Контакты"',
            ],
            [
                'key' => 'contacts.hero.subtitle',
                'value' => 'Мы всегда готовы ответить на ваши вопросы. Звоните, пишите или приезжайте к нам в офис.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Контакты"',
            ],
            [
                'key' => 'portfolio.hero.label',
                'value' => 'Наши работы',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Портфолио"',
            ],
            [
                'key' => 'portfolio.hero.title',
                'value' => 'Портфолио',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Портфолио"',
            ],
            [
                'key' => 'portfolio.hero.subtitle',
                'value' => 'Более 500 реализованных проектов для малого бизнеса, торговых сетей и корпоративных клиентов по всей России.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Наши услуги"',
            ],
            [
                'key' => 'services.hero.label',
                'value' => 'Что мы делаем',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Наши услуги"',
            ],
            [
                'key' => 'services.hero.title',
                'value' => 'Наши услуги',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Наши услуги"',
            ],
            [
                'key' => 'services.hero.subtitle',
                'value' => 'Полный производственный цикл — от разработки дизайна до монтажа. Работаем с любыми объектами и масштабами.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Портфолио"',
            ],
            [
                'key' => 'services.process.label',
                'value' => 'Как мы работаем',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в process-блоке страницы "Наши услуги"',
            ],
            [
                'key' => 'services.process.title',
                'value' => 'Этапы производства',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок process-блока страницы "Наши услуги"',
            ],
            [
                'key' => 'service.process.label',
                'value' => 'Как проходит работа',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в process-блоке страницы услуги',
            ],
            [
                'key' => 'service.process.title',
                'value' => 'Этапы выполнения',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок process-блока страницы услуги',
            ],
            [
                'key' => 'service.process.subtitle',
                'value' => 'Мы выстроили процесс так, чтобы клиент тратил минимум времени и получал предсказуемый результат в оговорённые сроки.',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок process-блока страницы услуги',
            ],
        ];

        // Очищаем старые настройки
        Setting::truncate();

        // Создаем новые
        foreach ($settings as $setting) {
            // Если тип JSON и значение - массив, кодируем в JSON
            if ($setting['type'] === SettingType::JSON && is_array($setting['value'])) {
                $setting['value'] = json_encode($setting['value'], JSON_UNESCAPED_UNICODE);
            }

            Setting::create($setting);
        }

        $this->command->info('Настройки успешно импортированы!');
    }
}

```

### database/seeders/SiteStatisticSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}

```

### database/seeders/SliderSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class SliderSeeder extends Seeder
{
    protected array $items = [

        [
            'title' => '15',
            'excerpt' => 'лет совокупного опыта команды',
            'image' => 'team.webp',
            'content' => 'Столько наши мастера работают с фрезеровкой, лазером и УФ-печатью. Мы не просто делаем вывески — мы знаем материал.',
        ],

        [
            'title' => '0,1 мм',
            'excerpt' => 'точность лазерной резки',
            'image' => 'laser.webp',
            'content' => 'Идеальный рез на сложных формах.',
        ],

        [
            'title' => '100%',
            'excerpt' => 'кастомных проектов',
            'image' => 'castom_projects.webp',
            'content' => 'С нуля под ваш бизнес.',
        ],

        [
            'title' => '1 год',
            'excerpt' => 'гарантии на все изделия',
            'image' => 'guaranty.webp',
            'content' => 'От фрезеровки и печати до сварки и монтажа.',
        ],

        [
            'title' => '30+',
            'excerpt' => 'компаний выбрали живой свет',
            'image' => 'living_light.webp',
            'content' => 'Добавьте к этому списку и свой бренд.',
        ],

    ];

    public function run(): void
    {
        Slider::truncate();

        foreach ($this->items as $index => $item) {

            $attachment = Attachment::where('original_name', $item['image'])->first();

            if (! $attachment) {
                $this->command->warn("Attachment {$item['image']} не найден");

                continue;
            }

            Slider::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['excerpt'],
                'content' => $item['content'],
                'preview_id' => $attachment->id,
                'detail_id' => $attachment->id,
                'sort' => $index + 1,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $this->command->info("Создан слайд: {$item['title']}");
        }
    }
}

```

### database/seeders/TagSeeder.php

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'title' => 'Объемные буквы',
                'slug' => Str::slug('Объемные буквы'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Световые короба',
                'slug' => Str::slug('Световые короба'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Материалы',
                'slug' => Str::slug('Материалы'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Дизайн и стиль',
                'slug' => Str::slug('Дизайн и стиль'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Монтаж и сервис',
                'slug' => Str::slug('Монтаж и сервис'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Типы подсветки',
                'slug' => Str::slug('Типы подсветки'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Интерьерная реклама',
                'slug' => Str::slug('Интерьерная реклама'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Бюджетирование',
                'slug' => Str::slug('Бюджетирование'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Согласование',
                'slug' => Str::slug('Согласование'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Сезонность',
                'slug' => Str::slug('Сезонность'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tags')->insert($tags);

        $this->command->info('Tags seeded successfully!');
    }
}

```

### database/seeders/TechnologySeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TechnologySeeder extends Seeder
{
    protected array $items = [
        [
            'title' => 'Объёмные буквы любой сложности',
            'icon' => 'tech-letter',
            'text' => 'Литые, фрезерованные, гнутые. С торцевой, прямой, контражурной подсветкой или без. Любые шрифты и размеры.',
        ],
        [
            'title' => 'Точная лазерная гравировка',
            'icon' => 'tech-laser',
            'text' => 'Фотографическое качество гравировки на акриле, металле, дереве. Глубина и контраст — по техзаданию.',
        ],
        [
            'title' => 'Широкоформатная печать',
            'icon' => 'tech-print',
            'text' => 'Баннеры, стенды, интерьерная отделка, витражная плёнка. Размеры — от стикера до полноэтажного баннера.',
        ],
        [
            'title' => '3D-фрезеровка и рельеф',
            'icon' => 'tech-miling',
            'text' => 'Рельефные логотипы, декоративные панели, объёмные декоры интерьера. Глубина рельефа — до 50 мм.',
        ],
        [
            'title' => 'УФ-печать по жёстким основаниям',
            'icon' => 'tech-uv',
            'text' => 'Прямая печать на акриле, ПВХ, металле, стекле, керамике. Белая подложка, глянец или мат, лак-оверпринт.',
        ],
        [
            'title' => 'Монтаж LED-подсветки',
            'icon' => 'tech-led',
            'text' => 'Проектируем и монтируем системы подсветки на базе LED-модулей и линеек Samsung, Epistar. Блоки питания — промышленные.',
        ],
    ];

    public function run(): void
    {
        Technology::truncate();

        foreach ($this->items as $index => $item) {
            Technology::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['icon'],
                'content' => $item['text'],
                'sort' => $index + 1,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $this->command->info("Создано преимущество: {$item['title']}");
        }
    }
}

```

