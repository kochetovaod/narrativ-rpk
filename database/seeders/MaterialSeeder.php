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
