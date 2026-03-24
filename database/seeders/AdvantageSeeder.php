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
