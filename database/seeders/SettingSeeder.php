<?php

// database/seeders/SettingSeeder.php

namespace Database\Seeders;

use App\Enums\SettingGroup;
use App\Enums\SettingType;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Orchid\Attachment\Models\Attachment;

class SettingSeeder extends Seeder
{
    /**
     * Получить ID аттачмента по его original_name
     */
    protected function getAttachmentId(string $originalName): ?int
    {
        $attachment = Attachment::where('original_name', $originalName)->first();

        return $attachment?->id;
    }

    public function run(): void
    {
        // Получаем ID созданных изображений
        $logoId = $this->getAttachmentId('logo.webp');
        $this->command->info($logoId ? "Найден ID для logo.webp: $logoId" : 'Не найден аттачмент для logo.webp');

        $logoDarkId = $this->getAttachmentId('logo-dark.webp');
        $this->command->info($logoDarkId ? "Найден ID для logo-dark.webp: $logoDarkId" : 'Не найден аттачмент для logo-dark.webp');

        $logoMobileId = $this->getAttachmentId('logo-mobile.webp');
        $this->command->info($logoMobileId ? "Найден ID для logo-mobile.webp: $logoMobileId" : 'Не найден аттачмент для logo-mobile.webp');

        $favicon32Id = $this->getAttachmentId('favicon-32x32.webp');
        $this->command->info($favicon32Id ? "Найден ID для favicon-32x32.webp: $favicon32Id" : 'Не найден аттачмент для favicon-32x32.webp');

        $appleTouchIconId = $this->getAttachmentId('apple-touch-icon.webp');
        $this->command->info($appleTouchIconId ? "Найден ID для apple-touch-icon.webp: $appleTouchIconId" : 'Не найден аттачмент для apple-touch-icon.webp');

        $androidChrome192Id = $this->getAttachmentId('android-chrome-192x192.webp');
        $this->command->info($androidChrome192Id ? "Найден ID для android-chrome-192x192.webp: $androidChrome192Id" : 'Не найден аттачмент для android-chrome-192x192.webp');

        $androidChrome512Id = $this->getAttachmentId('android-chrome-512x512.webp');
        $this->command->info($androidChrome512Id ? "Найден ID для android-chrome-512x512.webp: $androidChrome512Id" : 'Не найден аттачмент для android-chrome-512x512.webp');

        $faviconIcoId = $this->getAttachmentId('favicon.ico');
        $this->command->info($faviconIcoId ? "Найден ID для favicon.ico: $faviconIcoId" : 'Не найден аттачмент для favicon.ico');

        $favicon16Id = $this->getAttachmentId('favicon-16x16.webp');
        $this->command->info($favicon16Id ? "Найден ID для favicon-16x16.webp: $favicon16Id" : 'Не найден аттачмент для favicon-16x16.webp');

        $ogImageId = $this->getAttachmentId('og-image.webp');
        $this->command->info($ogImageId ? "Найден ID для og-image.webp: $ogImageId" : 'Не найден аттачмент для og-image.webp');

        $sitePreviewId = $this->getAttachmentId('site-preview.webp');
        $this->command->info($sitePreviewId ? "Найден ID для site-preview.webp: $sitePreviewId" : 'Не найден аттачмент для site-preview.webp');

        $decor1 = $this->getAttachmentId('decor1.webp');
        $this->command->info($decor1 ? "Найден ID для decor1.webp: $decor1" : 'Не найден аттачмент для decor1.webp');

        $decor2 = $this->getAttachmentId('decor2.webp');
        $this->command->info($decor2 ? "Найден ID для decor2.webp: $decor2" : 'Не найден аттачмент для decor2.webp');

        $decor3 = $this->getAttachmentId('decor3.webp');
        $this->command->info($decor3 ? "Найден ID для decor3.webp: $decor3" : 'Не найден аттачмент для decor3.webp');

        $decor4 = $this->getAttachmentId('decor4.webp');
        $this->command->info($decor4 ? "Найден ID для decor4.webp: $decor4" : 'Не найден аттачмент для decor4.webp');

        $bridge1 = $this->getAttachmentId('bridge1.webp');
        $this->command->info($bridge1 ? "Найден ID для bridge1.webp: $bridge1" : 'Не найден аттачмент для bridge1.webp');

        $bridge2 = $this->getAttachmentId('bridge2.webp');
        $this->command->info($bridge2 ? "Найден ID для bridge2.webp: $bridge2" : 'Не найден аттачмент для bridge2.webp');

        $bridge3 = $this->getAttachmentId('bridge3.webp');
        $this->command->info($bridge3 ? "Найден ID для bridge3.webp: $bridge3" : 'Не найден аттачмент для bridge3.webp');

        $bridge4 = $this->getAttachmentId('bridge4.webp');
        $this->command->info($bridge4 ? "Найден ID для bridge4.webp: $bridge4" : 'Не найден аттачмент для bridge4.webp');
        // Используем updateOrCreate вместо import, чтобы избежать проблемы с мета-данными
        $settings = [
            // Основные настройки
            [
                'key' => 'site_name',
                'value' => 'Нарратив',
                'type' => SettingType::STRING,
                'group' => SettingGroup::GENERAL,
                'description' => 'Название сайта',
            ],
            [
                'key' => 'site_description',
                'value' => 'Производство и установка наружной рекламы. Полный цикл от идеи до
                    реализации.',
                'type' => SettingType::STRING,
                'group' => SettingGroup::GENERAL,
                'description' => 'Описание сайта',
            ],
            [
                'key' => 'site_logo',
                'value' => $logoId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Логотип сайта',
            ],
            [
                'key' => 'site_logo_dark',
                'value' => $logoDarkId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Логотип для темного фона',
            ],
            [
                'key' => 'site_logo_mobile',
                'value' => $logoMobileId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Логотип для мобильной версии',
            ],
            [
                'key' => 'favicon_ico',
                'value' => $faviconIcoId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Favicon ICO (для старых браузеров)',
            ],
            [
                'key' => 'favicon_16',
                'value' => $favicon16Id,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Favicon 16x16 (WebP)',
            ],
            [
                'key' => 'favicon_32',
                'value' => $favicon32Id,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Favicon 32x32 (WebP)',
            ],
            [
                'key' => 'apple_touch_icon',
                'value' => $appleTouchIconId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Apple Touch Icon (для iPhone/iPad)',
            ],
            [
                'key' => 'android_chrome_192',
                'value' => $androidChrome192Id,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Android Chrome 192x192',
            ],
            [
                'key' => 'android_chrome_512',
                'value' => $androidChrome512Id,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Android Chrome 512x512',
            ],

            // Open Graph изображения
            [
                'key' => 'og_image',
                'value' => $ogImageId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::SEO,
                'description' => 'Open Graph изображение (для соцсетей)',
            ],
            [
                'key' => 'site_preview',
                'value' => $sitePreviewId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::SEO,
                'description' => 'Site Preview изображение (альтернативное)',
            ],
            [
                'key' => 'maintenance_mode',
                'value' => false,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::GENERAL,
                'description' => 'Режим обслуживания',
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'Сайт временно недоступен, ведутся технические работы',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::GENERAL,
                'description' => 'Сообщение в режиме обслуживания',
            ],
            // Изображения для декора
            [
                'key' => 'decor1',
                'value' => $decor1,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в блоках без картинок на фоне',
            ],
            [
                'key' => 'decor2',
                'value' => $decor2,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в блоках без картинок на фоне',
            ],
            [
                'key' => 'decor3',
                'value' => $decor3,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в футере на фоне',
            ],
            [
                'key' => 'decor4',
                'value' => $decor4,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в футере на фоне',
            ],
            [
                'key' => 'bridge1',
                'value' => $bridge1,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в блоках без картинок на фоне',
            ],
            [
                'key' => 'bridge2',
                'value' => $bridge2,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в блоках без картинок на фоне',
            ],
            [
                'key' => 'bridge3',
                'value' => $bridge3,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в футере на фоне',
            ],
            [
                'key' => 'bridge4',
                'value' => $bridge4,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::GENERAL,
                'description' => 'Квадратная картинка для декора сайта. Используется в футере на фоне',
            ],
            // Контакты
            [
                'key' => 'contact_phone',
                'value' => '+7 (999) 123-45-67',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Основной телефон',
            ],
            [
                'key' => 'contact_phone_2',
                'value' => '+7 (999) 765-43-21',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Дополнительный телефон',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@narrative.ru',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Email для связи',
            ],
            [
                'key' => 'contact_address',
                'value' => 'г. Москва, ул. Примерная, д. 123',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Адрес офиса/производства',
            ],
            // КООРДИНАТЫ ДЛЯ КАРТЫ
            [
                'key' => 'map_latitude',
                'value' => '55.7558',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Широта для карты (Yandex/Google)',
            ],
            [
                'key' => 'map_longitude',
                'value' => '37.6176',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Долгота для карты (Yandex/Google)',
            ],
            [
                'key' => 'map_zoom',
                'value' => 17,
                'type' => SettingType::INTEGER,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Уровень приближения карты',
            ],
            [
                'key' => 'map_placemark_title',
                'value' => 'Нарратив - Производство рекламы',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Название метки на карте',
            ],
            [
                'key' => 'map_placemark_body',
                'value' => 'Производство и монтаж наружной рекламы<br>Режим работы: Пн-Пт 9:00-18:00',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Описание в метке карты',
            ],
            [
                'key' => 'map_api_key_yandex',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'API ключ для Яндекс.Карт',
            ],
            [
                'key' => 'map_api_key_google',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'API ключ для Google Maps',
            ],
            [
                'key' => 'working_hours',
                'value' => 'Пн-Пт: 9:00 - 18:00, Сб-Вс: выходной',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Режим работы',
            ],
            [
                'key' => 'how_to_get_text',
                'value' => 'На метро: ст. м. Текстильщики (выход №3), далее 5 минут пешком или автобус №193 до остановки «Производственная улица».<br>На автомобиле: со стороны МКАД (Каширское шоссе), въезд на территорию по пропуску.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Текст "Как добраться"',
            ],
            // Реквизиты компании
            [
                'key' => 'company_name',
                'value' => 'ООО «Нарратив»',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Полное наименование компании',
            ],
            [
                'key' => 'company_inn',
                'value' => '7712345678',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'ИНН',
            ],
            [
                'key' => 'company_kpp',
                'value' => '771201001',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'КПП',
            ],
            [
                'key' => 'company_ogrn',
                'value' => '1127746123456',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'ОГРН',
            ],
            [
                'key' => 'company_bank_account',
                'value' => '40702810123450101234',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Расчётный счёт',
            ],
            [
                'key' => 'company_bank_name',
                'value' => 'АО «Сбербанк России»',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Название банка',
            ],
            [
                'key' => 'company_bank_bik',
                'value' => '044525225',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'БИК банка',
            ],
            [
                'key' => 'company_correspondent_account',
                'value' => '30101810400000000225',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTACTS,
                'description' => 'Корреспондентский счёт',
            ],
            // Социальные сети
            [
                'key' => 'social_vk',
                'value' => 'https://vk.com/narrative',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'ВКонтакте',
            ],
            [
                'key' => 'social_telegram',
                'value' => 'https://t.me/narrative',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'Telegram канал',
            ],
            [
                'key' => 'social_whatsapp',
                'value' => 'https://wa.me/79991234567',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'WhatsApp',
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/narrative',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'Instagram',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@narrative',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'YouTube канал',
            ],
            [
                'key' => 'social_viber',
                'value' => 'viber://chat?number=%2B79991234567',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SOCIAL,
                'description' => 'Viber',
            ],
            // SEO - расширенные настройки
            [
                'key' => 'seo_default_title',
                'value' => 'Нарратив - Производство и монтаж наружной рекламы в Москве',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SEO,
                'description' => 'SEO заголовок по умолчанию',
            ],
            [
                'key' => 'seo_default_description',
                'value' => 'Профессиональное производство и монтаж наружной рекламы в Москве. Широкий выбор материалов, собственное производство, опытные монтажники.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'SEO описание по умолчанию',
            ],
            [
                'key' => 'seo_default_keywords',
                'value' => 'наружная реклама, производство рекламы, монтаж рекламы, вывески, рекламные щиты, Москва',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'SEO ключевые слова по умолчанию',
            ],
            [
                'key' => 'seo_og_image',
                'value' => $ogImageId,
                'type' => SettingType::IMAGE,
                'group' => SettingGroup::SEO,
                'description' => 'Изображение для Open Graph (соцсети)',
            ],
            [
                'key' => 'seo_robots_txt',
                'value' => "User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: https://narrative.ru/sitemap.xml",
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Содержимое robots.txt',
            ],
            [
                'key' => 'seo_yandex_verification',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SEO,
                'description' => 'Код верификации Яндекс',
            ],
            [
                'key' => 'seo_google_verification',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::SEO,
                'description' => 'Код верификации Google',
            ],
            [
                'key' => 'seo_metrika_counter',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Код счетчика Яндекс.Метрики',
            ],
            [
                'key' => 'seo_analytics_counter',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Код счетчика Google Analytics',
            ],
            [
                'key' => 'seo_meta_tags',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Дополнительные meta-теги (в head)',
            ],
            [
                'key' => 'seo_scripts_body_start',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Скрипты после открытия body',
            ],
            [
                'key' => 'seo_scripts_body_end',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::SEO,
                'description' => 'Скрипты перед закрытием body',
            ],
            // Telegram - расширенные
            [
                'key' => 'telegram_bot_token',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Токен Telegram бота',
            ],
            [
                'key' => 'telegram_chat_id',
                'value' => '',
                'type' => SettingType::STRING,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'ID чата для уведомлений',
            ],
            [
                'key' => 'telegram_notifications_enabled',
                'value' => true,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Включить уведомления в Telegram',
            ],
            [
                'key' => 'telegram_notify_new_order',
                'value' => true,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Уведомлять о новых заказах',
            ],
            [
                'key' => 'telegram_notify_new_feedback',
                'value' => true,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Уведомлять о новых сообщениях из форм',
            ],
            [
                'key' => 'telegram_notify_new_user',
                'value' => false,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::TELEGRAM,
                'description' => 'Уведомлять о регистрации новых пользователей',
            ],
            // Email
            [
                'key' => 'email_notifications_enabled',
                'value' => true,
                'type' => SettingType::BOOLEAN,
                'group' => SettingGroup::EMAIL,
                'description' => 'Включить email-уведомления',
            ],
            [
                'key' => 'email_admin',
                'value' => 'admin@narrative.ru',
                'type' => SettingType::STRING,
                'group' => SettingGroup::EMAIL,
                'description' => 'Email для получения уведомлений',
            ],
            [
                'key' => 'email_sales',
                'value' => 'sales@narrative.ru',
                'type' => SettingType::STRING,
                'group' => SettingGroup::EMAIL,
                'description' => 'Email для заказов',
            ],
            [
                'key' => 'email_support',
                'value' => 'support@narrative.ru',
                'type' => SettingType::STRING,
                'group' => SettingGroup::EMAIL,
                'description' => 'Email техподдержки',
            ],
            [
                'key' => 'email_from_name',
                'value' => 'Нарратив',
                'type' => SettingType::STRING,
                'group' => SettingGroup::EMAIL,
                'description' => 'Имя отправителя писем',
            ],
            [
                'key' => 'email_signature',
                'value' => 'С уважением, команда "Нарратив"',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::EMAIL,
                'description' => 'Подпись в письмах',
            ],
            // Дизайн и внешний вид
            [
                'key' => 'theme_primary_color',
                'value' => '#3B82F6',
                'type' => SettingType::COLOR,
                'group' => SettingGroup::DESIGN,
                'description' => 'Основной цвет',
            ],
            [
                'key' => 'theme_secondary_color',
                'value' => '#10B981',
                'type' => SettingType::COLOR,
                'group' => SettingGroup::DESIGN,
                'description' => 'Вторичный цвет',
            ],
            [
                'key' => 'theme_font_family',
                'value' => 'Inter, sans-serif',
                'type' => SettingType::STRING,
                'group' => SettingGroup::DESIGN,
                'description' => 'Основной шрифт',
            ],
            [
                'key' => 'custom_css',
                'value' => '',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::DESIGN,
                'description' => 'Пользовательский CSS',
            ],
            // Уведомления
            [
                'key' => 'notification_position',
                'value' => 'bottom-right',
                'type' => SettingType::STRING,
                'group' => SettingGroup::NOTIFICATIONS,
                'description' => 'Позиция всплывающих уведомлений',
            ],
            [
                'key' => 'notification_duration',
                'value' => 5000,
                'type' => SettingType::INTEGER,
                'group' => SettingGroup::NOTIFICATIONS,
                'description' => 'Длительность показа уведомлений (мс)',
            ],
            // контент страниц
            [
                'key' => 'about.hero.label',
                'value' => 'Кто мы такие',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "О компании"',
            ],
            [
                'key' => 'about.hero.title',
                'value' => 'О компании Нарратив',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "О компании"',
            ],
            [
                'key' => 'about.hero.subtitle',
                'value' => 'Производим наружную и интерьерную рекламу с 2010 года. За это время реализовали более 500 проектов для малого бизнеса и крупных сетей.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "О компании"',
            ],
            [
                'key' => 'about.advantages.label',
                'value' => 'Почему выбирают нас',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл секции преимуществ',
            ],
            [
                'key' => 'about.advantages.title',
                'value' => 'Наши преимущества',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок секции преимуществ',
            ],
            [
                'key' => 'about.partners.label',
                'value' => 'Наши партнёры',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл секции партнёров',
            ],
            [
                'key' => 'about.partners.title',
                'value' => 'Кто с нами работает',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок секции партнёров',
            ],
            [
                'key' => 'about.equipment.label',
                'value' => 'Наше производство',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл секции оборудования',
            ],
            [
                'key' => 'about.equipment.title',
                'value' => 'Оборудование',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок секции оборудования',
            ],
            [
                'key' => 'about.equipment.subtitle',
                'value' => 'Собственный цех оснащён современным оборудованием ведущих мировых брендов.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок секции оборудования',
            ],
            [
                'key' => 'about.equipment.button_all',
                'value' => 'Всё оборудование',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Текст кнопки "Всё оборудование" на превью',
            ],
            [
                'key' => 'about.portfolio.label',
                'value' => 'Наши работы',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл секции портфолио',
            ],
            [
                'key' => 'about.portfolio.title',
                'value' => 'Лучшие проекты',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок секции портфолио',
            ],
            [
                'key' => 'about.portfolio.button_all',
                'value' => 'Смотреть все проекты',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Текст кнопки "Смотреть все проекты"',
            ],
            [
                'key' => 'about.cta.label',
                'value' => 'Готовы к сотрудничеству',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл CTA-блока',
            ],
            [
                'key' => 'about.cta.title',
                'value' => 'Обсудим ваш проект?',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок CTA-блока',
            ],
            [
                'key' => 'about.cta.subtitle',
                'value' => 'Расскажите нам о вашем бизнесе и задачах — мы предложим лучшее решение и просчитаем смету.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок CTA-блока',
            ],
            [
                'key' => 'about.cta.btn_call',
                'value' => 'Заказать звонок',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Текст кнопки "Заказать звонок"',
            ],
            [
                'key' => 'about.cta.btn_write',
                'value' => 'Написать нам',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Текст кнопки "Написать нам"',
            ],
            [
                'key' => 'about.intro.btn_catalog',
                'value' => 'Каталог продукции',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Кнопка "Каталог продукции" в intro-блоке',
            ],
            [
                'key' => 'about.intro.btn_contacts',
                'value' => 'Связаться с нами',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Кнопка "Связаться с нами" в intro-блоке',
            ],
            [
                'key' => 'equipment.hero.label',
                'value' => 'Наш цех',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.hero.title',
                'value' => 'Оборудование и технологии',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.hero.subtitle',
                'value' => 'Производственная база площадью 800 м² с современными станками ведущих мировых
                брендов. Всё оборудование — собственное, без субподряда.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.main.label',
                'value' => 'Парк станков',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в главном блоке страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.main.title',
                'value' => 'Фрезерное и лазерное оборудование',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок главном блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.technology.label',
                'value' => 'Технологические возможности',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в блоке технологий страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.technology.title',
                'value' => 'Что мы умеем делать',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок блока технологий страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.material.label',
                'value' => 'Сырьё и расходники',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в блоке материалов страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'equipment.material.title',
                'value' => 'Материалы, с которыми мы работаем',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок блока материалов страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'blog.hero.label',
                'value' => 'Экспертный контент',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'blog.hero.title',
                'value' => 'Блог о рекламе и производстве',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'blog.hero.subtitle',
                'value' => 'Рассказываем о технологиях, материалах, дизайне и практических кейсах из нашей работы.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Оборудование и технологии"',
            ],
            [
                'key' => 'faq.hero.label',
                'value' => 'Частые вопросы',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "FAQ"',
            ],
            [
                'key' => 'faq.hero.title',
                'value' => 'Всё, что вы хотели узнать',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "FAQ"',
            ],
            [
                'key' => 'faq.hero.subtitle',
                'value' => 'Собрали ответы на 30+ вопросов о производстве, ценах, сроках, монтаже и гарантии.
                Не нашли своё — спросите напрямую.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "FAQ"',
            ],
            [
                'key' => 'contacts.hero.label',
                'value' => 'Свяжитесь с нами',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Контакты"',
            ],
            [
                'key' => 'contacts.hero.title',
                'value' => 'Контакты',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Контакты"',
            ],
            [
                'key' => 'contacts.hero.subtitle',
                'value' => 'Мы всегда готовы ответить на ваши вопросы. Звоните, пишите или приезжайте к нам в офис.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Контакты"',
            ],
            [
                'key' => 'portfolio.hero.label',
                'value' => 'Наши работы',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Портфолио"',
            ],
            [
                'key' => 'portfolio.hero.title',
                'value' => 'Портфолио',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Портфолио"',
            ],
            [
                'key' => 'portfolio.hero.subtitle',
                'value' => 'Более 500 реализованных проектов для малого бизнеса, торговых сетей и корпоративных клиентов по всей России.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Наши услуги"',
            ],
            [
                'key' => 'services.hero.label',
                'value' => 'Что мы делаем',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в hero-блоке страницы "Наши услуги"',
            ],
            [
                'key' => 'services.hero.title',
                'value' => 'Наши услуги',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок hero-блока страницы "Наши услуги"',
            ],
            [
                'key' => 'services.hero.subtitle',
                'value' => 'Полный производственный цикл — от разработки дизайна до монтажа. Работаем с любыми объектами и масштабами.',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок hero-блока страницы "Портфолио"',
            ],
            [
                'key' => 'services.process.label',
                'value' => 'Как мы работаем',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в process-блоке страницы "Наши услуги"',
            ],
            [
                'key' => 'services.process.title',
                'value' => 'Этапы производства',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Заголовок process-блока страницы "Наши услуги"',
            ],
            [
                'key' => 'service.process.label',
                'value' => 'Как проходит работа',
                'type' => SettingType::TEXT,
                'group' => SettingGroup::CONTENT,
                'description' => 'Лейбл в process-блоке страницы услуги',
            ],
            [
                'key' => 'service.process.title',
                'value' => 'Этапы выполнения',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок process-блока страницы услуги',
            ],
            [
                'key' => 'service.process.subtitle',
                'value' => 'Мы выстроили процесс так, чтобы клиент тратил минимум времени и получал предсказуемый результат в оговорённые сроки.',
                'type' => SettingType::STRING,
                'group' => SettingGroup::CONTENT,
                'description' => 'Подзаголовок process-блока страницы услуги',
            ],
        ];

        // Очищаем старые настройки
        Setting::truncate();

        // Создаем новые
        foreach ($settings as $setting) {
            // Если тип JSON и значение - массив, кодируем в JSON
            if ($setting['type'] === SettingType::JSON && is_array($setting['value'])) {
                $setting['value'] = json_encode($setting['value'], JSON_UNESCAPED_UNICODE);
            }

            Setting::create($setting);
        }

        $this->command->info('Настройки успешно импортированы!');
    }
}
