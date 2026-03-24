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
