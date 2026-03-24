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
