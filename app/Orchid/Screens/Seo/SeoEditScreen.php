<?php

namespace App\Orchid\Screens\Seo;

use App\Models\SEO as Seo;
use App\Orchid\Layouts\Seo\SeoEditLayout;
use App\Orchid\Layouts\Seo\SeoEntityInfoLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class SeoEditScreen extends Screen
{
    /**
     * @var Seo
     */
    public $seo;

    /**
     * Query data.
     */
    public function query(Seo $seo): array
    {
        // Загружаем связи
        $seo->load(['ogImage']);

        return [
            'seo' => $seo,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        $entity = $this->seo->seoable;

        if ($entity) {
            $title = $entity->title ?? $entity->name ?? 'Без названия';

            return 'SEO: '.$title;
        }

        return 'Редактирование SEO';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Редактирование SEO-данных';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->class('btn btn-success me-2'),

            Button::make('Применить')
                ->icon('reload')
                ->method('save')
                ->parameters(['redirect' => 'edit'])
                ->class('btn btn-primary me-2'),

            Button::make('Отмена')
                ->icon('close')
                ->method('cancel')
                ->confirm('Вы уверены? Несохранённые данные будут потеряны.')
                ->class('btn btn-secondary'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            new SeoEntityInfoLayout($this->seo),
            new SeoEditLayout($this->seo),
        ];
    }

    /**
     * Сохранение SEO данных
     */
    public function save(Seo $seo, Request $request): RedirectResponse
    {
        $redirect = $request->get('redirect', 'list');

        // Валидация
        $request->validate([
            'seo.title' => 'nullable|string|max:255',
            'seo.description' => 'nullable|string|max:500',
            'seo.keywords' => 'nullable|string|max:255',
            'seo.og_title' => 'nullable|string|max:255',
            'seo.og_description' => 'nullable|string|max:500',
            'seo.canonical_url' => 'nullable|string|max:255',
            'seo.robots' => 'nullable|string|max:50',
            'seo.og_image_id' => 'nullable|integer|exists:attachments,id',
        ]);

        // Сохраняем данные
        $seo->fill($request->get('seo'))->save();

        Alert::success('SEO данные успешно сохранены.');

        // Редирект в зависимости от кнопки
        if ($redirect === 'edit') {
            return redirect()->route('platform.seo.edit', $seo);
        }

        return redirect()->route('platform.seo.list');
    }

    /**
     * Отмена редактирования
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('platform.seo.list');
    }

    /**
     * Права доступа
     */
    public function permission(): ?array
    {
        return [
            'platform.settings.manage',
        ];
    }
}
