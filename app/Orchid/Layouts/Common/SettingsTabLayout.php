<?php

namespace App\Orchid\Layouts\Common;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;

/**
 * Переиспользуемый слой для вкладок настроек (Bitrix-стиль)
 */
class SettingsTabLayout extends Rows
{
    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [];
    }

    /**
     * Вкладка "Общие настройки"
     */
    public static function generalTab(): array
    {
        return [
            Layout::rows([
                Input::make('settings.site_name')
                    ->title('Название сайта')
                    ->placeholder('Нарратив')
                    ->help('Отображается в заголовке браузера и в шапке сайта'),

                TextArea::make('settings.site_description')
                    ->title('Краткое описание сайта')
                    ->rows(3)
                    ->maxlength(500)
                    ->placeholder('Производство и монтаж световых вывесок...')
                    ->help('Используется в мета-тегах и на главной странице'),

                CheckBox::make('settings.maintenance_mode')
                    ->title('Режим обслуживания')
                    ->placeholder('Включить')
                    ->sendTrueOrFalse()
                    ->help('При включении сайт будет показывать страницу "Сайт на обслуживании" для обычных посетителей'),
            ]),
        ];
    }

    /**
     * Вкладка "Контакты"
     */
    public static function contactsTab(): Rows
    {
        return Layout::rows([
            Input::make('settings.site_phone_main')
                ->title('Основной телефон')
                ->placeholder('+7 (846) 123-45-67')
                ->mask('+7 (999) 999-99-99')
                ->help('Отображается в шапке и подвале сайта'),

            Input::make('settings.site_phone_additional')
                ->title('Дополнительный телефон')
                ->placeholder('+7 (846) 765-43-21')
                ->mask('+7 (999) 999-99-99')
                ->help('Дополнительный номер для связи'),

            Input::make('settings.site_email')
                ->title('Email для заявок')
                ->placeholder('info@example.ru')
                ->type('email')
                ->help('На этот адрес будут приходить уведомления о новых заявках'),

            TextArea::make('settings.site_address')
                ->title('Адрес производства')
                ->rows(2)
                ->placeholder('г. Самара, ул. Производственная, 10')
                ->help('Отображается в подвале сайта'),

            Input::make('settings.site_coords_lat')
                ->title('Широта')
                ->placeholder('53.195873')
                ->help('Координаты для карты на странице контактов'),

            Input::make('settings.site_coords_lng')
                ->title('Долгота')
                ->placeholder('50.100193')
                ->help('Координаты для карты на странице контактов'),
        ]);
    }

    /**
     * Вкладка "Telegram"
     */
    public static function telegramTab(): array
    {
        return [
            Layout::rows([
                Input::make('settings.telegram_bot_token')
                    ->title('Токен Telegram бота')
                    ->placeholder('123456789:ABCdefGHIjklMNOpqrsTUVwxyz')
                    ->type('password')
                    ->help('Получить токен можно у @BotFather в Telegram'),

                Input::make('settings.telegram_chat_id')
                    ->title('ID чата для уведомлений')
                    ->placeholder('-1001234567890')
                    ->help('ID чата или канала, куда будут приходить уведомления о заявках'),
            ]),
        ];
    }

    /**
     * Вкладка "SEO по умолчанию"
     */
    public static function seoTab(): array
    {
        return [
            Layout::rows([
                Input::make('settings.seo_default_title')
                    ->title('SEO заголовок (по умолчанию)')
                    ->placeholder('Нарратив — Наружная реклама в Самаре')
                    ->maxlength(60)
                    ->help('Используется на страницах без индивидуального SEO'),

                TextArea::make('settings.seo_default_description')
                    ->title('SEO описание (по умолчанию)')
                    ->rows(3)
                    ->maxlength(160)
                    ->placeholder('Производство световых вывесок...')
                    ->help('Используется на страницах без индивидуального SEO'),
            ]),
        ];
    }

    /**
     * Вкладка "Социальные сети"
     */
    public static function socialTab(): array
    {
        return [
            Layout::rows([
                Input::make('settings.social_telegram')
                    ->title('Ссылка на Telegram')
                    ->placeholder('https://t.me/your_channel')
                    ->help('Ссылка в футере сайта и социальных кнопках'),

                Input::make('settings.social_vk')
                    ->title('Ссылка на ВКонтакте')
                    ->placeholder('https://vk.com/your_group')
                    ->help('Ссылка в футере сайта и социальных кнопках'),

                Input::make('settings.social_instagram')
                    ->title('Ссылка на Instagram')
                    ->placeholder('https://instagram.com/your_account')
                    ->help('Ссылка в футере сайта и социальных кнопках'),
            ]),
        ];
    }

    /**
     * Получить все доступные вкладки
     */
    public static function getTabs(): array
    {
        return [
            'Общие' => self::generalTab(),
            'Контакты' => self::contactsTab(),
            'Telegram' => self::telegramTab(),
            'SEO' => self::seoTab(),
            'Соцсети' => self::socialTab(),
        ];
    }
}
