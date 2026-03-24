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
