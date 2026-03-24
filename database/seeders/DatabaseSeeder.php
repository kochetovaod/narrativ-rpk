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
