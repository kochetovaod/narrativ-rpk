<?php

namespace App\Orchid\Screens\Settings;

use App\Enums\SettingGroup;
use App\Models\Setting;
use App\Orchid\Layouts\Settings\ContactsSettingsLayout;
use App\Orchid\Layouts\Settings\DesignSettingsLayout;
use App\Orchid\Layouts\Settings\EmailSettingsLayout;
use App\Orchid\Layouts\Settings\GeneralSettingsLayout;
use App\Orchid\Layouts\Settings\NotificationsSettingsLayout;
use App\Orchid\Layouts\Settings\SeoSettingsLayout;
use App\Orchid\Layouts\Settings\SocialSettingsLayout;
use App\Orchid\Layouts\Settings\TelegramSettingsLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class SettingsScreen extends Screen
{
    public function name(): ?string
    {
        return 'Настройки сайта';
    }

    public function description(): ?string
    {
        return 'Глобальные настройки проекта';
    }

    public function query(): iterable
    {
        return [
            'settings' => Setting::all()
                ->mapWithKeys(fn ($setting) => [
                    $setting->key => $setting->typed_value,
                ])->toArray(),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::tabs([
                SettingGroup::GENERAL->label() => GeneralSettingsLayout::class,
                SettingGroup::CONTACTS->label() => ContactsSettingsLayout::class,
                SettingGroup::SOCIAL->label() => SocialSettingsLayout::class,
                SettingGroup::SEO->label() => SeoSettingsLayout::class,
                SettingGroup::TELEGRAM->label() => TelegramSettingsLayout::class,
                SettingGroup::EMAIL->label() => EmailSettingsLayout::class,
                SettingGroup::DESIGN->label() => DesignSettingsLayout::class,
                SettingGroup::NOTIFICATIONS->label() => NotificationsSettingsLayout::class,
            ]),
        ];
    }

    public function save(Request $request)
    {
        $data = $request->input('settings', []);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Настройки сохранены');
    }
}
