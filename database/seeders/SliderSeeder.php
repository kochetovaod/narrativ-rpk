<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class SliderSeeder extends Seeder
{
    protected array $items = [

        [
            'title' => '15',
            'excerpt' => 'лет совокупного опыта команды',
            'image' => 'team.webp',
            'content' => 'Столько наши мастера работают с фрезеровкой, лазером и УФ-печатью. Мы не просто делаем вывески — мы знаем материал.',
        ],

        [
            'title' => '0,1 мм',
            'excerpt' => 'точность лазерной резки',
            'image' => 'laser.webp',
            'content' => 'Идеальный рез на сложных формах.',
        ],

        [
            'title' => '100%',
            'excerpt' => 'кастомных проектов',
            'image' => 'castom_projects.webp',
            'content' => 'С нуля под ваш бизнес.',
        ],

        [
            'title' => '1 год',
            'excerpt' => 'гарантии на все изделия',
            'image' => 'guaranty.webp',
            'content' => 'От фрезеровки и печати до сварки и монтажа.',
        ],

        [
            'title' => '30+',
            'excerpt' => 'компаний выбрали живой свет',
            'image' => 'living_light.webp',
            'content' => 'Добавьте к этому списку и свой бренд.',
        ],

    ];

    public function run(): void
    {
        Slider::truncate();

        foreach ($this->items as $index => $item) {

            $attachment = Attachment::where('original_name', $item['image'])->first();

            if (! $attachment) {
                $this->command->warn("Attachment {$item['image']} не найден");

                continue;
            }

            Slider::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['excerpt'],
                'content' => $item['content'],
                'preview_id' => $attachment->id,
                'detail_id' => $attachment->id,
                'sort' => $index + 1,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $this->command->info("Создан слайд: {$item['title']}");
        }
    }
}
