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
