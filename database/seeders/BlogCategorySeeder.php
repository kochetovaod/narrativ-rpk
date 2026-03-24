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
