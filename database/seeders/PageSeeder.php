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
