<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class PortfolioSeeder extends Seeder
{
    protected array $items = [

        [
            'title' => 'Оформление фасада гипермаркета «Самара-Сити»',
            'image' => 'samara-city-main.webp',
            'excerpt' => 'Комплексное обновление фасадной вывески и входной группы крупнейшего гипермаркета Самары.',
            'content' => 'samara-city.md',
            'client' => 'Самара-Сити',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование', 'Обшивка фасадов'],
            'products' => ['Объемные буквы с фронтальным свечением', 'Композитный короб с инкрустацией'],
            'images' => [
                'samara-city-1.webp',
                'samara-city-2.webp',
                'samara-city-3.webp',
                'samara-city-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '15.03.2019',
            'budget' => 450000,
            'address' => 'ул. Ново-Садовая, 160',
            'properties' => [
                'Количество объектов' => '1 здание',
                'Срок выполнения' => '3 недели',
                'Материал лицевой' => 'Акрил 5 мм',
                'Борта' => 'Композит 4 мм',
                'Подсветка' => 'LED 2835, 6000K',
                'Гарантия' => '2 года',
            ],
        ],
        [
            'title' => 'Неоновая вывеска и интерьерное оформление бутика «Стиль+»',
            'image' => 'styleplus-main.webp',
            'excerpt' => 'Разработка и монтаж неоновой вывески, интерьерных световых панелей и навигации для модного бутика.',
            'content' => 'styleplus.md',
            'client' => 'Стиль+',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Винтажные световые буквы'],
            'images' => [
                'styleplus-main.webp',
                'styleplus-1.webp',
                'styleplus-2.webp',
                'styleplus-3.webp',
                'styleplus-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '22.08.2020',
            'budget' => 180000,
            'address' => 'ул. Ленинградская, 42',
            'properties' => [
                'Срок выполнения' => '10 дней',
                'Тип неона' => 'Гибкий неон',
                'Цвет свечения' => 'Розовый',
                'Мощность' => '120 Вт',
            ],
        ],
        [
            'title' => 'Яркое фасадное и интерьерное оформление магазина «Мир детства»',
            'image' => 'mirdetstva-main.webp',
            'excerpt' => 'Производство и монтаж объемных букв с пиксельной подсветкой, световых коробов и интерьерной навигации для магазина игрушек.',
            'content' => 'mirdetstva.md',
            'client' => 'Мир детства',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Объемные буквы с пиксельной подсветкой', 'Фигурный световой короб'],
            'images' => [
                'mirdetstva-main.webp',
                'mirdetstva-1.webp',
                'mirdetstva-2.webp',
                'mirdetstva-3.webp',
                'mirdetstva-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '10.12.2021',
            'budget' => 320000,
            'address' => 'пр. Кирова, 255',
            'properties' => [
                'Количество объектов' => '5 элементов',
                'Срок выполнения' => '2 недели',
                'Режим подсветки' => 'Динамический',
                'Пульт управления' => 'В комплекте',
            ],
        ],
        [
            'title' => 'Неоновая вывеска и винтажные световые буквы для бара «Креатив»',
            'image' => 'kreativ-main.webp',
            'excerpt' => 'Создание яркого ночного образа бара с неоновой вывеской, ретро-буквами и интерьерной подсветкой.',
            'content' => 'kreativ.md',
            'client' => 'Креатив',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Винтажные световые буквы'],
            'images' => [
                'kreativ-main.webp',
                'kreativ-1.webp',
                'kreativ-2.webp',
                'kreativ-3.webp',
                'kreativ-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '05.06.2022',
            'budget' => 250000,
            'address' => 'ул. Молодогвардейская, 67',
            'properties' => [
                'Стиль' => 'Винтаж',
                'Материал' => 'Латунь, акрил',
                'Цветовая температура' => '2700K',
                'Диммирование' => 'Есть',
            ],
        ],
        [
            'title' => 'Фасад ресторана «Русская трапеза» с контражурными объемными буквами',
            'image' => 'russkaya-trapeza-main.webp',
            'excerpt' => 'Оформление фасада ресторана с объемными буквами с контражурной подсветкой и декоративными элементами.',
            'content' => 'russkaya-trapeza.md',
            'client' => 'Русская трапеза',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Объемные буквы с контражурной подсветкой'],
            'images' => [
                'russkaya-trapeza-main.webp',
                'russkaya-trapeza-1.webp',
                'russkaya-trapeza-2.webp',
                'russkaya-trapeza-3.webp',
                'russkaya-trapeza-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '18.09.2022',
            'budget' => 550000,
            'address' => 'наб. Волги, 15',
            'properties' => [
                'Стиль' => 'Русский классический',
                'Материал' => 'Нержавейка, акрил',
                'Размер букв' => '1200 мм',
                'Количество' => '12 букв',
                'Крепление' => 'Фрезерованные шпильки',
            ],
        ],
        [
            'title' => 'Премиальное фасадное оформление автосалона «АвтоЛюкс»',
            'image' => 'autolux-main.webp',
            'excerpt' => 'Цельносветовые короба и композитная обшивка фасада для автосалона премиум-класса.',
            'content' => 'autolux.md',
            'client' => 'АвтоЛюкс',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Обшивка фасадов', 'Сварочные работы'],
            'products' => ['Цельносветовой короб', 'Композитный короб с инкрустацией'],
            'images' => [
                'autolux-main.webp',
                'autolux-1.webp',
                'autolux-2.webp',
                'autolux-3.webp',
                'autolux-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '03.11.2020',
            'budget' => 890000,
            'address' => 'Московское шоссе, 18 км',
            'properties' => [
                'Площадь остекления' => '120 м²',
                'Материал обшивки' => 'Алюкобонд',
                'Толщина композита' => '4 мм',
                'Количество световых коробов' => '3 шт',
                'Общая мощность' => '2.5 кВт',
            ],
        ],
        [
            'title' => 'Объёмные буквы с контражурной подсветкой для автосервиса «ТехноСервис»',
            'image' => 'tehnoservice-main.webp',
            'excerpt' => 'Изготовление и монтаж объёмных букв с контражурной подсветкой и светового короба для фасада автомастерской.',
            'content' => 'tehnoservice.md',
            'client' => 'ТехноСервис',
            'services' => ['Изготовление вывесок', 'Монтажные работы'],
            'products' => ['Объемные буквы с контражурной подсветкой', 'Цельносветовой короб'],
            'images' => [
                'tehnoservice-main.webp',
                'tehnoservice-1.webp',
                'tehnoservice-2.webp',
                'tehnoservice-3.webp',
                'tehnoservice-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '12.02.2023',
            'budget' => 210000,
            'address' => 'ул. Авроры, 150',
            'properties' => [
                'Материал' => 'Сталь, акрил',
                'Защита' => 'Антивандальная',
                'Цвет' => 'Черный матовый',
                'Подсветка' => 'LED 6500K',
            ],
        ],
        [
            'title' => 'Световые короба и интерьерная навигация для медцентра «Здоровье семьи»',
            'image' => 'zdorovye-main.webp',
            'excerpt' => 'Комплексное оформление фасада и интерьера медицинского центра: световые короба, навигационные таблички и информационные стенды.',
            'content' => 'zdorovye.md',
            'client' => 'Здоровье семьи',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Интерьерная печать', 'Плоттерная резка'],
            'products' => ['Короб с фронтальной подсветкой', 'Плоские буквы без подсветки'],
            'images' => [
                'zdorovye-main.webp',
                'zdorovye-1.webp',
                'zdorovye-2.webp',
                'zdorovye-3.webp',
                'zdorovye-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '07.04.2021',
            'budget' => 380000,
            'address' => 'ул. Советской Армии, 210',
            'properties' => [
                'Количество табличек' => '45 шт',
                'Материал' => 'ПВХ, акрил',
                'Способ нанесения' => 'УФ-печать',
                'Навигация' => 'Тактильная',
                'Стенды' => '5 шт',
            ],
        ],
        [
            'title' => 'Объёмные буквы с фронтальным свечением и акрилайты для стоматологии «Белоснежка»',
            'image' => 'belosnezhka-main.webp',
            'excerpt' => 'Изготовление вывески из объёмных букв с белой фронтальной подсветкой и декоративных акрилайтов для интерьера стоматологической клиники.',
            'content' => 'belosnezhka.md',
            'client' => 'Белоснежка',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Фрезеровка', 'Лазерная резка'],
            'products' => ['Объемные буквы с фронтальным свечением'],
            'images' => [
                'belosnezhka-main.webp',
                'belosnezhka-1.webp',
                'belosnezhka-2.webp',
                'belosnezhka-3.webp',
                'belosnezhka-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '19.05.2022',
            'budget' => 195000,
            'address' => 'ул. Победы, 84',
            'properties' => [
                'Материал' => 'Акрил белый',
                'Толщина' => '10 мм',
                'Подсветка' => 'LED 4000K',
                'Крепление' => 'Сплит-система',
            ],
        ],
        [
            'title' => 'Комплексное оформление отделения банка «Волга-Кредит»',
            'image' => 'volgakredit-main.webp',
            'excerpt' => 'Полный цикл работ по оформлению банковского отделения: обшивка фасада композитом, монтаж объёмных букв с подсветкой и световых коробов.',
            'content' => 'volgakredit.md',
            'client' => 'Волга-Кредит',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Обшивка фасадов', 'Сварочные работы'],
            'products' => ['Объемные буквы с фронтальным свечением', 'Композитный короб с инкрустацией', 'Цельносветовой короб'],
            'images' => [
                'volgakredit-main.webp',
                'volgakredit-1.webp',
                'volgakredit-2.webp',
                'volgakredit-3.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '28.07.2019',
            'budget' => 750000,
            'address' => 'ул. Куйбышева, 95',
            'properties' => [
                'Площадь фасада' => '200 м²',
                'Материал' => 'Композит 3 мм',
                'Брендбук' => 'Соблюден',
                'Сроки' => '4 недели',
                'Гарантия' => '3 года',
            ],
        ],
        [
            'title' => 'Динамическая вывеска и тканевые лайтбоксы для фитнес-клуба «Атлетик»',
            'image' => 'atletik-main.webp',
            'excerpt' => 'Объёмные буквы с динамической подсветкой, крупноформатные тканевые лайтбоксы и интерьерные световые панели для фитнес-клуба.',
            'content' => 'atletik.md',
            'client' => 'Атлетик',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'УФ-печать', 'Интерьерная печать'],
            'products' => ['Объемные буквы с динамической подсветкой', 'Цельносветовой короб'],
            'images' => [
                'atletik-main.webp',
                'atletik-1.webp',
                'atletik-2.webp',
                'atletik-3.webp',
                'atletik-4.webp',
                'atletik-5.webp',
                'atletik-6.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '14.09.2023',
            'budget' => 680000,
            'address' => 'ул. Дачная, 24',
            'properties' => [
                'Режимы подсветки' => '8 программ',
                'Пульт ДУ' => 'В комплекте',
                'Материал коробов' => 'Алюминий',
                'Ткань' => 'Баннерная сетка',
                'Яркость' => '3000 Люмен',
            ],
        ],
        [
            'title' => 'Неоновая вывеска и тонкие световые панели для студии маникюра «Красота ногтей»',
            'image' => 'krasota-main.webp',
            'excerpt' => 'Индивидуальная неоновая вывеска, настенные световые панели Crystal и декоративные акрилайты для beauty-студии.',
            'content' => 'krasota.md',
            'client' => 'Красота ногтей',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование', 'Фрезеровка'],
            'products' => ['Винтажные световые буквы', 'Плоские буквы без подсветки'],
            'images' => [
                'krasota-main.webp',
                'krasota-1.webp',
                'krasota-2.webp',
                'krasota-3.webp',
                'krasota-4.webp',
                'krasota-5.webp',
                'krasota-6.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '03.12.2023',
            'budget' => 145000,
            'address' => 'пр. Ленина, 3',
            'properties' => [
                'Стиль' => 'Минимализм',
                'Цвет неона' => 'Розовый кварц',
                'Материал панелей' => 'Оргстекло',
                'Мощность' => '80 Вт',
            ],
        ],
        [
            'title' => 'Пилон, объёмные буквы и информационные стенды для строительной компании «ДомСтрой»',
            'image' => 'domstroy-main.webp',
            'excerpt' => 'Изготовление и монтаж отдельностоящего рекламного пилона, объёмных букв без подсветки и мобильных информационных стендов для офиса продаж.',
            'content' => 'domstroy.md',
            'client' => 'ДомСтрой',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Сварочные работы', 'Плоттерная резка'],
            'products' => ['Объемные буквы без подсветки', 'Панель-кронштейн двухсторонняя'],
            'images' => [
                'domstroy-main.webp',
                'domstroy-1.webp',
                'domstroy-2.webp',
                'domstroy-3.webp',
                'domstroy-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '21.10.2020',
            'budget' => 420000,
            'address' => 'ул. Георгия Димитрова, 112',
            'properties' => [
                'Высота пилона' => '6 м',
                'Материал' => 'Металл, ПВХ',
                'Площадь стендов' => '12 м²',
                'Количество' => '8 шт',
            ],
        ],
        [
            'title' => 'Винтажные световые буквы и тканевые лайтбоксы для отеля «Комфорт»',
            'image' => 'komfort-main.webp',
            'excerpt' => 'Фасадные винтажные световые буквы в стиле ретро, тканевые лайтбоксы в холле и навигационные таблички для городского отеля.',
            'content' => 'komfort.md',
            'client' => 'Комфорт',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Интерьерная печать', 'УФ-печать'],
            'products' => ['Винтажные световые буквы', 'Цельносветовой короб'],
            'images' => [
                'komfort-main.webp',
                'komfort-1.webp',
                'komfort-2.webp',
                'komfort-3.webp',
                'komfort-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '08.02.2022',
            'budget' => 520000,
            'address' => 'ул. Гагарина, 67',
            'properties' => [
                'Стиль' => 'Ретро',
                'Материал' => 'Латунь, стекло',
                'Табличек' => '30 шт',
                'Режим работы' => 'Круглосуточно',
            ],
        ],
        [
            'title' => 'Цельносветовые буквы, лайтбоксы и POSM для турагентства «Путешествие мечты»',
            'image' => 'putmechty-main.webp',
            'excerpt' => 'Изготовление цельносветовых объёмных букв, оконных лайтбоксов и рекламных POSM-материалов из оргстекла для офиса турагентства.',
            'content' => 'putmechty.md',
            'client' => 'Путешествие мечты',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'УФ-печать', 'Лазерная резка'],
            'products' => ['Цельносветовые буквы', 'Короб с фронтальной подсветкой'],
            'images' => [
                'putmechty-main.webp',
                'putmechty-1.webp',
                'putmechty-2.webp',
                'putmechty-3.webp',
                'putmechty-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '11.07.2021',
            'budget' => 280000,
            'address' => 'ул. Пушкина, 56',
            'properties' => [
                'Форматы' => 'A4, A3, A2',
                'Материал' => 'Оргстекло 3 мм',
                'Стойки' => 'В комплекте',
                'Тираж' => '50 шт',
            ],
        ],
        [
            'title' => 'Объёмные буквы с пиксельной подсветкой для школы «English Time»',
            'image' => 'englishtime-main.webp',
            'excerpt' => 'Яркие объёмные буквы с пиксельной LED-подсветкой на фасаде и настольные световые панели Тейбл тент для зоны ресепшн языковой школы.',
            'content' => 'englishtime.md',
            'client' => 'English Time',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Дизайн и проектирование'],
            'products' => ['Объемные буквы с пиксельной подсветкой', 'Плоские буквы без подсветки'],
            'images' => [
                'englishtime-main.webp',
                'englishtime-1.webp',
                'englishtime-2.webp',
                'englishtime-3.webp',
                'englishtime-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '25.04.2023',
            'budget' => 230000,
            'address' => 'ул. Стара-Загора, 167',
            'properties' => [
                'Режимы' => '5 программ',
                'Управление' => 'С телефона',
                'Яркость' => 'Регулируемая',
                'Цвета' => 'RGB',
            ],
        ],
        [
            'title' => 'Фигурный световой короб для детского сада «Солнышко»',
            'image' => 'solnyshko-main.webp',
            'excerpt' => 'Фигурный световой короб в форме солнца, яркие объёмные буквы и навигационные таблички для частного детского сада.',
            'content' => 'solnyshko.md',
            'client' => 'Солнышко',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'Фрезеровка', 'Плоттерная резка'],
            'products' => ['Фигурный световой короб', 'Объемные буквы с фронтальным свечением'],
            'images' => [
                'solnyshko-main.webp',
                'solnyshko-1.webp',
                'solnyshko-2.webp',
                'solnyshko-3.webp',
                'solnyshko-4.webp',
                'solnyshko-5.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '16.08.2022',
            'budget' => 195000,
            'address' => 'ул. Юбилейная, 34',
            'properties' => [
                'Диаметр' => '1.5 м',
                'Материал' => 'Акрил цветной',
                'Цвета' => 'Желтый, оранжевый',
                'Безопасность' => '12V',
            ],
        ],
        [
            'title' => 'Плоские буквы с контражурной подсветкой для страховой компании «Капитал-Полис»',
            'image' => 'kapitalpolis-main.webp',
            'excerpt' => 'Строгие плоские буквы с контражурной подсветкой, двусторонняя панель-кронштейн и POSM-изделия для офиса страховой компании.',
            'content' => 'kapitalpolis.md',
            'client' => 'Капитал-Полис',
            'services' => ['Изготовление вывесок', 'Монтажные работы', 'УФ-печать'],
            'products' => ['Плоские буквы с контражурной подсветкой', 'Панель-кронштейн двухсторонняя'],
            'images' => [
                'kapitalpolis-main.webp',
                'kapitalpolis-1.webp',
                'kapitalpolis-2.webp',
                'kapitalpolis-3.webp',
                'kapitalpolis-4.webp',
            ],
            'city' => 'Самара',
            'completed_at' => '30.01.2024',
            'budget' => 315000,
            'address' => 'ул. Мичурина, 78',
            'properties' => [
                'Стиль' => 'Деловой',
                'Цвет' => 'Синий металлик',
                'Подсветка' => 'LED 5000K',
                'Гарантия' => '5 лет',
                'Антивандальная' => 'Да',
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->items as $index => $item) {
            $attachment = Attachment::where('original_name', $item['image'])->first();
            $attachments = [];

            foreach ($item['images'] as $image) {
                $file = Attachment::where('original_name', $image)->first();
                if ($file) {
                    array_push($attachments, $file);
                }
            }

            if (! $attachment) {
                $this->command->warn("⚠️ Attachment {$item['image']} не найден");

                continue;
            }

            $markdownPath = storage_path('app/public/seed/markdown/'.$item['content']);

            if (! file_exists($markdownPath)) {
                $this->command->warn("⚠️ Markdown файл {$item['content']} не найден по пути: {$markdownPath}");

                continue;
            }

            $client = Client::where('title', 'like', '%'.$item['client'].'%')->first();

            if (! $client) {
                $this->command->warn("⚠️ Клиент не найден: {$item['client']}");

                continue;
            }

            // Чтение содержимого Markdown
            $content = file_get_contents($markdownPath);

            // Преобразуем дату из формата дд.мм.гггг в объект Carbon
            $completedAt = Carbon::createFromFormat('d.m.Y', $item['completed_at']);

            $portfolio = Portfolio::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'excerpt' => $item['excerpt'],
                'content' => $content,
                'preview_id' => $attachment->id,
                'detail_id' => $attachment->id,
                'sort' => $index + 1,
                'client_id' => $client->id,
                'active' => true,
                'published_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
                // Новые поля
                'city' => $item['city'],
                'completed_at' => $completedAt,
                'budget' => $item['budget'],
                'address' => $item['address'],
                'properties' => json_encode($item['properties'], JSON_UNESCAPED_UNICODE),
            ]);

            // Прикрепляем изображения
            foreach ($attachments as $file) {
                $portfolio->attachments()->syncWithoutDetaching($file->id);
            }

            $this->command->info('✓ Прикреплено изображений: '.count($attachments));

            // Прикрепляем услуги (многие-ко-многим)
            if (isset($item['services'])) {
                foreach ($item['services'] as $serviceTitle) {
                    $service = Service::where('title', $serviceTitle)->first();
                    if ($service) {
                        $portfolio->services()->syncWithoutDetaching($service->id);
                        $this->command->info("  └─ Добавлена услуга: {$serviceTitle}");
                    } else {
                        $this->command->warn("  └─ ⚠️ Услуга не найдена: {$serviceTitle}");
                    }
                }
            }

            // Прикрепляем продукцию (многие-ко-многим)
            if (isset($item['products'])) {
                foreach ($item['products'] as $productTitle) {
                    $product = Product::where('title', $productTitle)->first();
                    if ($product) {
                        $portfolio->products()->syncWithoutDetaching($product->id);
                        $this->command->info("  └─ Добавлен продукт: {$productTitle}");
                    } else {
                        $this->command->warn("  └─ ⚠️ Продукт не найден: {$productTitle}");
                    }
                }
            }

            $this->command->info("✓ Создан проект портфолио: {$item['title']}");
            $this->command->info('---');
        }

        $this->command->info('🎉 Все проекты портфолио успешно созданы!');
    }
}
