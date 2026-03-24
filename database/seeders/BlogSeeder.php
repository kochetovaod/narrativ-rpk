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
